@php
    $state = $getState();
    $defaultLatitude = $getDefaultLatitude();
    $defaultLongitude = $getDefaultLongitude();
    $mapHeight = $getMapHeight();

    // Extract coordinates from state
    $latitude = null;
    $longitude = null;

    if (is_array($state)) {
        $latitude = $state['lat'] ?? $state['latitude'] ?? null;
        $longitude = $state['lng'] ?? $state['longitude'] ?? null;
    } elseif (is_object($state) && isset($state->latitude) && isset($state->longitude)) {
        $latitude = $state->latitude;
        $longitude = $state->longitude;
    } elseif (isset($state->latitude) && isset($state->longitude)) {
        $latitude = $state->latitude;
        $longitude = $state->longitude;
    }

    // Fallback to default coordinates if not found
    if ($latitude === null || $longitude === null) {
        $latitude = $defaultLatitude;
        $longitude = $defaultLongitude;
    }
@endphp

<div
    x-data="{
        hydratedCoordinates: @js(['lat' => $latitude, 'lng' => $longitude]),
        _instanceId: Math.random().toString(36).substr(2, 9),

        init() {
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
            const lat = this.hydratedCoordinates.lat;
            const lng = this.hydratedCoordinates.lng;

            this.map = new google.maps.Map(this.$refs.map, {
                zoom: 15,
                center: { lat, lng },
                draggable: false,
                scrollwheel: false,
                disableDefaultUI: true,
                gestureHandling: 'none'
            });

            // Use AdvancedMarkerElement if available
            if (google.maps.marker && google.maps.marker.AdvancedMarkerElement) {
                this.marker = new google.maps.marker.AdvancedMarkerElement({
                    map: this.map,
                    position: { lat, lng },
                    title: 'Location'
                });
            } else {
                // Fallback to classic marker
                this.marker = new google.maps.Marker({
                    position: { lat, lng },
                    map: this.map,
                    draggable: false,
                    title: 'Location'
                });
            }
        }
    }"
    wire:ignore
    {{ $getExtraAttributeBag()->class(['space-y-2']) }}
>
    <div x-ref="map" class="w-full bg-gray-200 rounded border" style="height: {{ $mapHeight }}px;"></div>
    <div class="text-sm text-gray-600">
        Lat: <span>{{ $latitude }}</span>,
        Lng: <span>{{ $longitude }}</span>
    </div>
</div>
