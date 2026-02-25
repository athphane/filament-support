<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        x-data="{
            state: $wire.$entangle('{{ $getStatePath() }}'),
            map: null,
            marker: null,
            hydratedCoordinates: null,
            _instanceId: Math.random().toString(36).substr(2, 9),

            init() {
                $wire.$watch('{{ $getStatePath() }}', (newState) => {
                    if (newState?.lat !== undefined && newState?.lng !== undefined) {
                        if (this.map && this.marker) {
                            this.updateMapPosition({ lat: newState.lat, lng: newState.lng });
                        } else {
                            this.hydratedCoordinates = { lat: newState.lat, lng: newState.lng };
                        }
                    }
                });
                this.loadGoogleMaps();
            },

            loadGoogleMaps() {
                if (window.google?.maps) {
                    this.initMap();
                    return;
                }
                if (window.googleMapsLoading) {
                    const checkReady = () => {
                        if (window.google?.maps) {
                            this.initMap();
                        } else {
                            setTimeout(checkReady, 100);
                        }
                    };
                    checkReady();
                    return;
                }
                window.googleMapsLoading = true;

                // Add a global callback handler for this instance
                if (!window.filamentCoordinateMaps) {
                    window.filamentCoordinateMaps = {};
                }
                window.filamentCoordinateMaps[this._instanceId] = this;

                // Set up of global callback if it doesn't exist
                if (!window.initFilamentCoordinateMaps) {
                    window.initFilamentCoordinateMaps = function() {
                        for (let id in window.filamentCoordinateMaps) {
                            const component = window.filamentCoordinateMaps[id];
                            if (component && typeof component.initMap === 'function') {
                                component.initMap();
                            }
                        }
                    };
                }

                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initFilamentCoordinateMaps`;
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            },

            initMap() {
                const lat = this.hydratedCoordinates?.lat ?? (this.state?.lat ?? {{ $getDefaultLatitude() }});
                const lng = this.hydratedCoordinates?.lng ?? (this.state?.lng ?? {{ $getDefaultLongitude() }});

                this.map = new google.maps.Map(this.$refs.map, {
                    zoom: 15,
                    center: { lat, lng },
                });

                // Use AdvancedMarkerElement if available
                if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
                    this.marker = new google.maps.marker.AdvancedMarkerElement({
                        map: this.map,
                        position: { lat, lng },
                        title: 'Selected location',
                        gmpDraggable: true
                    });

                    // Add drag event listener for AdvancedMarkerElement
                    if (this.marker.draggable) {
                        this.map.addListener('click', (e) => {
                            const clickLat = e.latLng.lat();
                            const clickLng = e.latLng.lng();
                            this.marker.position = { lat: clickLat, lng: clickLng };
                            this.state = { lat: clickLat, lng: clickLng };
                        });
                    }
                } else {
                    // Fallback to classic marker
                    this.marker = new google.maps.Marker({
                        position: { lat, lng },
                        map: this.map,
                        draggable: true,
                        title: 'Selected location'
                    });

                    this.marker.addListener('dragend', () => {
                        const pos = this.marker.getPosition();
                        this.state = { lat: pos.lat(), lng: pos.lng() };
                    });
                }

                this.map.addListener('click', (e) => {
                    const clickLat = e.latLng.lat();
                    const clickLng = e.latLng.lng();
                    if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
                        this.marker.position = { lat: clickLat, lng: clickLng };
                    } else {
                        this.marker.setPosition({ lat: clickLat, lng: clickLng });
                    }
                    this.state = { lat: clickLat, lng: clickLng };
                });
            },

            updateMapPosition(latlng) {
                if (this.map && this.marker) {
                    this.map.setCenter(latlng);
                    this.marker.position = latlng;
                }
            }
        }"
        wire:ignore
        {{ $getExtraAttributeBag()->class(['space-y-2']) }}
    >
        <div x-ref="map" class="w-full bg-gray-200 rounded border" style="height: {{ $getMapHeight() }}px;"></div>
        <div class="text-sm text-gray-600">
            Lat: <span x-text="state?.lat ?? 'N/A'"></span>,
            Lng: <span x-text="state?.lng ?? 'N/A'"></span>
        </div>
    </div>
</x-dynamic-component>
