<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Property Reporting System') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-light">
        <main class="container py-4 py-md-5">
            <section class="mx-auto complaint-panel">
                <form id="property-step" novalidate>
                    <input type="hidden" name="property" id="property-value">
                    <div class="mb-4">
                        <p class="step-label mb-2">Step 1 of 6</p>
                        <h1 class="h4 mb-2">Find your property</h1>
                        <p class="text-secondary mb-0">Search by address, postcode or property reference.</p>
                    </div>

                    <div class="search-field mb-4">
                        <span class="search-icon" aria-hidden="true">⌕</span>
                        <label for="property-search" class="visually-hidden">Search for a property</label>
                        <input type="search" id="property-search" class="form-control" placeholder="Search property or postcode" autocomplete="off">
                    </div>

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <hr class="flex-grow-1">
                        <span class="small text-secondary text-nowrap">Please select your property</span>
                        <hr class="flex-grow-1">
                    </div>

                    <div class="property-list d-none" id="property-list">
                        @foreach ($properties as $property)
                            <button type="button" class="property-option" data-property="{{ strtolower($property['ref'] . ' ' . $property['address'] . ' ' . $property['type'] . ' ' . $property['status']) }}" data-address="{{ $property['address'] }}" data-reference="{{ $property['ref'] }}">
                                <span class="property-address">{{ $property['address'] }}</span>
                                <span class="property-details">Ref: {{ $property['ref'] }} <span aria-hidden="true">|</span> {{ $property['type'] }} <span aria-hidden="true">|</span> {{ $property['status'] }}</span>
                            </button>
                        @endforeach
                    </div>

                    <p id="property-search-hint" class="text-center text-secondary py-4 mb-0">Start typing to search for your property.</p>
                    <p id="property-no-results" class="text-center text-secondary py-4 d-none mb-0">No matching properties found.</p>
                </form>

                <form id="complaint-step" class="d-none" novalidate>
                    <input type="hidden" name="property" id="complaint-property-value">
                    <input type="hidden" name="complaint_type" id="complaint-value">
                    <button type="button" class="back-link" id="complaint-back">Back</button>
                    <div class="mb-4">
                        <p class="step-label mb-2">Step 2 of 6</p>
                        <h1 class="h4 mb-2">What is the problem?</h1>
                        <p class="text-secondary mb-0">Property: <strong id="selected-property"></strong></p>
                    </div>

                    <label for="complaint-search" class="form-label">Please select the complaint type</label>
                    <div class="search-field mb-3">
                        <span class="search-icon" aria-hidden="true">⌕</span>
                        <input type="search" id="complaint-search" class="form-control" placeholder="Search complaint type" autocomplete="off">
                    </div>
                    <div class="choice-list" id="complaint-list">
                        @foreach (['Alley Gate Key', 'Baby Safety Gate', 'Bath Tub/Bath Panel', 'Blockage', 'Boiler', 'Bulb/Lighting', 'Carpet', 'Case Worker Issue', 'Cooker Issue', 'Council Inspection Jobs', 'Cupboard', 'Curtains Issue', 'Damp Proof Course', 'Damp/Mold', 'Drain Block', 'Electric and PAT Certificate', 'Electric Certificate', 'Electricity', 'EPC Certificate', 'External Door Issue', 'External Leakage', 'External Lock Change', 'Fan/Exhaust Fan', 'Fence', 'Fire Place', 'Floor', 'Fridge', 'Furniture', 'Garden Maintenance', 'Gas Certificate', 'Guttering', 'Hand Rail', 'Internal Door Issue', 'Internal Inspection Report', 'Internal Leakage', 'Internal Lock Change', 'Key Safe', 'Lino', 'Multiple Jobs', 'New Furniture', 'PAT Certificate', 'Pest Control/Mice Holes', 'PIV Unit', 'Pointing/Replaster', 'Property Cleaning', 'Radiator', 'Receiling', 'Redecoration', 'Removal', 'Renovation', 'Repairs', 'Roof Leakage', 'Roofer', 'Rubbish', 'Shower Issue', 'Sink/Basin', 'Skip', 'Slugs Issue', 'Smoke Alarm/Fire Alarm', 'Socket Issue', 'Stairs', 'Tap Issue', 'Tiles', 'Toilet Issue', 'Top Up', 'Water External', 'Wheelie Bins', 'Window'] as $complaintType)
                            <button type="button" class="choice-option complaint-option" data-complaint="{{ strtolower($complaintType) }}" data-value="{{ $complaintType }}">{{ $complaintType }}</button>
                        @endforeach
                    </div>
                    <p id="complaint-no-results" class="text-center text-secondary py-4 d-none mb-3">No matching complaint types found.</p>
                    <p class="selected-choice d-none" id="selected-complaint-choice"></p>
                </form>

                <form id="area-step" class="d-none" novalidate>
                    <input type="hidden" name="property" id="area-property-value">
                    <input type="hidden" name="complaint_type" id="area-complaint-value">
                    <input type="hidden" name="area" id="area-value">
                    <button type="button" class="back-link" id="area-back">Back</button>
                    <div class="mb-4">
                        <p class="step-label mb-2">Step 3 of 6</p>
                        <h1 class="h4 mb-2">Where is the problem?</h1>
                        <p class="text-secondary mb-1">Property: <strong id="area-selected-property"></strong></p>
                        <p class="text-secondary mb-0">Complaint: <strong id="selected-complaint"></strong></p>
                        <p id="area-no-results" class="text-center text-secondary py-4 d-none mb-0">No matching areas found.</p>
                        <p class="selected-area mt-3 mb-0 d-none" id="selected-area"></p>
                    </div>

                    <div class="search-field mb-4">
                        <span class="search-icon" aria-hidden="true">⌕</span>
                        <label for="area-search" class="visually-hidden">Search for an area</label>
                        <input type="search" id="area-search" class="form-control" placeholder="Search area" autocomplete="off">
                    </div>

                    <div class="area-list" id="area-list">
                        @foreach ([
                            ['name' => 'External Front', 'search' => 'EXTERNAL FRONT roof walls gutters windows doors gardens'],
                            ['name' => 'Downstairs Hallway', 'search' => 'DOWNSTAIRS HALLWAY'],
                            ['name' => 'Front Living Room', 'search' => 'FRONT LIVING ROOM windows internal doors damp plug light fittings flooring'],
                            ['name' => 'Back Living Room', 'search' => 'BACK LIVING ROOM windows internal doors damp plug light fittings flooring'],
                            ['name' => 'Kitchen', 'search' => 'KITCHEN appliances flooring tiling heating doors windows'],
                            ['name' => 'External Back', 'search' => 'EXTERNAL BACK roof walls gutters windows doors gardens'],
                            ['name' => 'Upstairs Hallway', 'search' => 'UPSTAIRS HALLWAY'],
                            ['name' => 'Bathroom', 'search' => 'BATHROOM bath shower toilet plumbing tiling windows doors'],
                            ['name' => 'Bedroom 1', 'search' => 'BEDROOM 1 flooring window doors damp heating light fittings plug sockets'],
                            ['name' => 'Bedroom 2', 'search' => 'BEDROOM 2 flooring window doors damp heating light fittings plug sockets'],
                            ['name' => 'Bedroom 3', 'search' => 'BEDROOM 3 flooring window doors damp heating light fittings plug sockets'],
                            ['name' => 'Bedroom 4', 'search' => 'BEDROOM 4 flooring window doors damp heating light fittings plug sockets'],
                            ['name' => 'Bedroom 5', 'search' => 'BEDROOM 5 flooring window doors damp heating light fittings plug sockets'],
                            ['name' => 'Pest Control', 'search' => 'PEST CONTROL evidence mice'],
                            ['name' => 'Landing / Stairs', 'search' => 'LANDING STAIRS LANDING handrails flooring light fittings']
                        ] as $area)
                            <button type="button" class="area-option" data-area="{{ strtolower($area['search']) }}">{{ $area['name'] }}</button>
                        @endforeach
                    </div>

                    
                </form>

                <form id="permission-step" class="d-none" novalidate>
                    <input type="hidden" name="property" id="permission-property-value">
                    <input type="hidden" name="complaint_type" id="permission-complaint-value">
                    <input type="hidden" name="area" id="permission-area-value">
                    <input type="hidden" name="spare_key_permission" id="spare-key-value">
                    <button type="button" class="back-link" id="permission-back">Back</button>

                    <div class="mb-4">
                        <p class="step-label mb-2">Step 4 of 6</p>
                        <h1 class="h4 mb-2">Spare key details</h1>
                        <p class="text-secondary mb-1">Area: <strong id="permission-selected-area"></strong></p>
                        <p class="selected-choice d-none mb-0" id="selected-permission"></p>
                        <p class="text-secondary mb-0">Choose permission and add a remark.</p>
                    </div>

                    <p class="form-label mb-2">Spare Key Permission</p>
                    <div class="permission-list" id="permission-list">
                        <button type="button" class="permission-option" data-permission="No">No</button>
                        <button type="button" class="permission-option" data-permission="Yes">Yes</button>
                    </div>
                    
                    <label for="spare-key-remark" class="form-label mt-3">Remark</label>
                    <textarea name="spare_key_remark" id="spare-key-remark" class="form-control" rows="3" placeholder="Add a remark"></textarea>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="compact-next" id="permission-next" disabled>Next</button>
                    </div>
                </form>

                <form id="upload-step" class="d-none" novalidate>
                    <input type="hidden" name="property" id="upload-property-value">
                    <input type="hidden" name="complaint_type" id="upload-complaint-value">
                    <input type="hidden" name="area" id="upload-area-value">
                    <input type="hidden" name="spare_key_permission" id="upload-permission-value">
                    <input type="hidden" name="spare_key_remark" id="upload-remark-value">
                    <button type="button" class="back-link" id="upload-back">Back</button>
                    <div class="mb-4">
                        <p class="step-label mb-2">Step 5 of 6</p>
                        <h1 class="h4 mb-2">Add photos or videos</h1>
                        <p class="text-secondary mb-0">Upload up to 10 files to support your complaint.</p>
                    </div>
                    <label for="media-files" class="upload-box">
                        <span class="upload-title">Choose images or videos</span>
                        <span class="upload-help">Maximum 10 files</span>
                    </label>
                    <input type="file" id="media-files" name="media[]" class="visually-hidden" accept="image/*,video/*" multiple>
                    <p id="upload-error" class="text-danger small d-none mt-2 mb-0"></p>
                    <div id="media-preview" class="media-preview mt-3"></div>
                    <div class="d-flex gap-2 mt-4 justify-content-end">
                        <button type="submit" class="compact-next " id="upload-next" disabled>Next</button>
                    </div>
                </form>

                <form id="personal-step" class="d-none" novalidate>
                    <input type="hidden" name="property" id="personal-property-value">
                    <input type="hidden" name="complaint_type" id="personal-complaint-value">
                    <input type="hidden" name="area" id="personal-area-value">
                    <input type="hidden" name="spare_key_permission" id="personal-permission-value">
                    <input type="hidden" name="spare_key_remark" id="personal-remark-value">
                    <button type="button" class="back-link" id="personal-back">Back</button>
                    <div class="mb-4">
                        <p class="step-label mb-2">Step 6 of 6</p>
                        <h1 class="h4 mb-2">Personal information</h1>
                        <p class="text-secondary mb-0">Enter your details to complete the form.</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label">Title</label>
                            <select id="title" name="title" class="form-select">
                                <option value="">Select title</option>
                                <option>Mr</option>
                                <option>Mrs</option>
                                <option>Ms</option>
                                <option>Miss</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="first-name" class="form-label">First name</label>
                            <input type="text" id="first-name" name="first_name" class="form-control" autocomplete="given-name" required>
                        </div>
                        <div class="col-12">
                            <label for="last-name" class="form-label">Last name</label>
                            <input type="text" id="last-name" name="last_name" class="form-control" autocomplete="family-name" required>
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" autocomplete="email" required>
                        </div>
                        <div class="col-12">
                            <label for="phone" class="form-label">Phone number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" autocomplete="tel" required>
                        </div>
                        <div class="col-12">
                            <label for="other-phone" class="form-label">Other phone number</label>
                            <input type="tel" id="other-phone" name="other_phone" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="postcode" class="form-label">Search for your postcode</label>
                            <input type="text" id="postcode" name="postcode" class="form-control" autocomplete="postal-code">
                            <button type="button" class="btn btn-link btn-sm px-0">Enter address manually</button>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea id="address" name="address" class="form-control" rows="2" autocomplete="street-address"></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="alarm-information" class="form-label">Alarm information</label>
                            <input type="text" id="alarm-information" name="alarm_information" class="form-control">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="parking-restrictions" class="form-label">Parking restrictions</label>
                            <input type="text" id="parking-restrictions" name="parking_restrictions" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="pet-information" class="form-label">Pet information</label>
                            <input type="text" id="pet-information" name="pet_information" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="partner-name" class="form-label">Partner name</label>
                            <input type="text" id="partner-name" name="partner_name" class="form-control">
                        </div>
                        <div class="col-12">
                            
                            <div class="form-check">
                                <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                                <label for="terms" class="form-check-label">I agree to the terms and conditions and privacy notice.</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="compact-next submit-action mt-4">Submit Complaint</button>
                    <p id="submit-message" class="text-success text-center small d-none mt-3 mb-0">Form ready. No data has been saved yet.</p>
                </form>
            </section>
        </main>
    </body>
</html>
