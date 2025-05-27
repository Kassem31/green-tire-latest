@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Create Inspection Transaction</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('inspection-transactions.store') }}">
                    @csrf

                    <div class="form-group mb-4">
                        <label for="barcode">Barcode</label>
                        <div class="input-group">
                            <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror"
                                name="barcode" value="{{ old('barcode') }}" required autofocus>
                            <button class="btn btn-outline-secondary" type="button" id="validate_barcode">
                                <i class="fas fa-search"></i> {{ __('Validate') }}
                            </button>
                        </div>
                        <small class="form-text text-muted">{{ __('Enter barcode and click validate or press Enter') }}</small>
                        <div id="barcode_feedback" class="invalid-feedback d-none"></div>
                        @error('barcode')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label>Tire Type</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($tireTypes as $tireType)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="tire_type_id"
                                        id="tire_type_{{ $tireType->id }}" value="{{ $tireType->id }}"
                                        {{ old('tire_type_id') == $tireType->id ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="tire_type_{{ $tireType->id }}">
                                        {{ __($tireType->name_en) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('tire_type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="machine">Machine</label>
                        <input id="machine" type="text" class="form-control @error('machine') is-invalid @enderror"
                            name="machine" value="{{ old('machine') }}">
                        @error('machine')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="operator_name">Operator Name</label>
                        <input id="operator_name" type="text" class="form-control @error('operator_name') is-invalid @enderror"
                            name="operator_name" value="{{ old('operator_name') }}">
                        @error('operator_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="operator_code">Operator Code</label>
                        <input id="operator_code" type="text" class="form-control @error('operator_code') is-invalid @enderror"
                            name="operator_code" value="{{ old('operator_code') }}">
                        @error('operator_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="observation_select">Observations:</label>
                        <div class="input-group mb-3">
                            <select id="observation_select" class="form-select">>
                                <option value="">{{ __('Select Observation') }}</option>
                                @foreach($observations as $observation)
                                    <option value="{{ $observation->id }}" data-name="{{ $observation->name_en }} ({{ $observation->name_ar }})">
                                        {{ $observation->name_en }} ({{ $observation->name_ar }})
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-primary" type="button" id="add_observation">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                        </div>
                        <div id="selected_observations_container" class="border p-3 rounded mb-3 hidden d-none">
                            <div id="selected_observations_list" class="d-flex flex-wrap gap-2">
                                <!-- Selected observations will be added here -->
                            </div>
                        </div>
                        <div id="observations_error" class="invalid-feedback d-none">
                            {{ __('This observation has already been added.') }}
                        </div>
                        @error('observations')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4" id="decision_row" style="display: none;">
                        <label>Decision</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" id="decision_repair"
                                    value="Repair" {{ old('decision', 'Repair') == 'Repair' ? 'checked' : '' }}>
                                <label class="form-check-label" for="decision_repair">{{ __('Repair') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" id="decision_scrap"
                                    value="Scrap" {{ old('decision') == 'Scrap' ? 'checked' : '' }}>
                                <label class="form-check-label" for="decision_scrap">{{ __('Scrap') }}</label>
                            </div>
                        </div>
                        @error('decision')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('inspection-transactions.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('barcode').focus();

        // Remove previous Tom Select implementation to avoid conflicts
        const obsSelect = document.getElementById('observation_select');

        // Initialize a regular select - don't use Tom Select until issues are fixed
        obsSelect.classList.add('form-select');

        // Get the observation select element
        const observationSelect = document.getElementById('observation_select');
        const addObservationBtn = document.getElementById('add_observation');
        const selectedObservationsListDiv = document.getElementById('selected_observations_list');
        const observationsError = document.getElementById('observations_error');
        const selectedObservationsContainer = document.getElementById('selected_observations_container');

        // Form validation
        const form = document.querySelector('form');
        let barcodeValidated = false;

        form.addEventListener('submit', function(event) {
            const barcode = barcodeInput.value.trim();

            if (!barcode) {
                event.preventDefault();
                barcodeInput.classList.add('is-invalid');
                barcodeFeedback.textContent = 'Please enter a barcode';
                barcodeFeedback.className = 'invalid-feedback d-block';
                return;
            }

            if (!barcodeValidated) {
                event.preventDefault();
                barcodeInput.classList.add('is-invalid');
                barcodeFeedback.textContent = 'Please validate and use an existing barcode before submitting';
                barcodeFeedback.className = 'invalid-feedback d-block';
                return;
            }
        });

        // --- Decision Visibility Logic ---
        const tireTypeRadios = document.querySelectorAll('input[name="tire_type_id"]');
        const decisionRow = document.getElementById('decision_row');
        const decisionRadios = document.querySelectorAll('input[name="decision"]');

        function toggleDecisionVisibility() {
            const selectedTireType = document.querySelector('input[name="tire_type_id"]:checked');
            // Only show decision options for Green Tire type (ID 2)
            // This ensures backward compatibility - if you add more tire types, you can adjust this logic
            const greenTireId = '2'; // Green Tire ID
            if (selectedTireType && selectedTireType.value === greenTireId) {
                decisionRow.style.display = ''; // Show the row
                decisionRadios.forEach(radio => radio.required = true);
            } else {
                decisionRow.style.display = 'none'; // Hide the row
                decisionRadios.forEach(radio => radio.required = false);
            }
        }

        // Add event listeners to tire type radios
        tireTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleDecisionVisibility);
        });

        // Initial check on page load
        toggleDecisionVisibility();
        // --- End Decision Visibility Logic ---

        // Helper to check if observation is already added
        function isObservationAdded(id) {
            return !!selectedObservationsListDiv.querySelector(`input[name="observations[]"][value="${id}"]`);
        }

        // Add observation to the list div
        function addObservationToDiv(id, name) {
            // Create wrapper div for each observation badge
            const wrapper = document.createElement('div');
            wrapper.className = 'badge bg-secondary me-2 mb-2 d-flex align-items-center';
            wrapper.style.padding = '0.5em 0.75em';
            wrapper.style.color = 'white'; // Ensure text is white

            // Hidden input for form submission
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'observations[]';
            input.value = id;
            wrapper.appendChild(input);

            // Display name
            const span = document.createElement('span');
            span.textContent = name;
            span.className = 'me-2';
            span.style.color = 'white'; // Ensure text is white
            wrapper.appendChild(span);

            // Remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerHTML = '&times;';
            removeBtn.style.border = 'none';
            removeBtn.style.background = 'none';
            removeBtn.style.color = 'white';
            removeBtn.style.cursor = 'pointer';
            removeBtn.style.fontSize = '1.1em';
            removeBtn.style.lineHeight = '1';
            removeBtn.style.padding = '0 0.2em';

            removeBtn.onclick = function() {
                wrapper.remove();
                updateContainerVisibility();
            };
            wrapper.appendChild(removeBtn);

            selectedObservationsListDiv.appendChild(wrapper);
            updateContainerVisibility();
        }

        // Show error helper
        function showError(message) {
            observationsError.textContent = message;
            observationsError.classList.remove('d-none');
            observationsError.classList.add('d-block');
            setTimeout(() => {
                observationsError.classList.remove('d-block');
                observationsError.classList.add('d-none');
            }, 2000);
        }

        // Update container visibility based on content
        function updateContainerVisibility() {
            if (selectedObservationsListDiv.children.length === 0) {
                selectedObservationsContainer.classList.add('d-none');
            } else {
                selectedObservationsContainer.classList.remove('d-none');
            }
        }

        // Add observation button click
        addObservationBtn.addEventListener('click', function() {
            try {
                const selectedOption = observationSelect.options[observationSelect.selectedIndex];
                const observationId = observationSelect.value;
                if (!observationId) {
                    showError('Please select an observation first');
                    return;
                }
                if (isObservationAdded(observationId)) {
                    showError('This observation has already been added');
                    return;
                }
                const observationName = selectedOption.dataset.name;
                addObservationToDiv(observationId, observationName);
                observationSelect.value = '';
            } catch (e) {
                console.error("Error in add observation handler:", e);
                showError('Error adding observation. Please try again.');
            }
        });

        // Restore old observations if validation fails
        @if(is_array(old('observations')) && count(old('observations')) > 0)
            @foreach(old('observations') as $observationId)
                @php
                    $obs = $observations->find($observationId);
                @endphp
                @if($obs)
                    addObservationToDiv('{{ $obs->id }}', '{{ $obs->name_en }} ({{ $obs->name_ar }})');
                @endif
            @endforeach
        @endif

        // Initial check for visibility on page load
        updateContainerVisibility();

        // --- Barcode Validation and Autofill ---
        const barcodeInput = document.getElementById('barcode');
        const validateBarcodeBtn = document.getElementById('validate_barcode');
        const barcodeFeedback = document.getElementById('barcode_feedback');
        const machineInput = document.getElementById('machine');
        const operatorNameInput = document.getElementById('operator_name');
        const operatorCodeInput = document.getElementById('operator_code');

        // Function to validate barcode using API
        function validateBarcode(barcode) {
            // Show loading state
            validateBarcodeBtn.disabled = true;
            validateBarcodeBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validating...';

            // Get CSRF token safely
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            // Make AJAX request to our API endpoint
            fetch('/api/validate-barcode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ barcode: barcode })
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                validateBarcodeBtn.disabled = false;
                validateBarcodeBtn.innerHTML = '<i class="fas fa-search"></i> {{ __("Validate") }}';

                if (data.success) {
                    if (data.exists) {
                        // Mark barcode as validated
                        barcodeValidated = true;

                        // Barcode exists, autofill the data
                        operatorNameInput.value = data.data.operator_name || '';
                        operatorCodeInput.value = data.data.operator_code || '';
                        machineInput.value = data.data.machine || '';

                        // Show success message
                        barcodeInput.classList.add('is-valid');
                        barcodeInput.classList.remove('is-invalid');
                        barcodeFeedback.textContent = 'Barcode validated successfully!';
                        barcodeFeedback.className = 'valid-feedback d-block';
                    } else {
                        // Barcode doesn't exist in the system - NOT valid for form submission
                        barcodeValidated = false;

                        barcodeInput.classList.remove('is-valid');
                        barcodeInput.classList.add('is-invalid');
                        barcodeFeedback.textContent = 'Barcode not found in the system. Cannot proceed with this barcode.';
                        barcodeFeedback.className = 'invalid-feedback d-block';

                        // Clear any previously autofilled data
                        operatorNameInput.value = '';
                        operatorCodeInput.value = '';
                        machineInput.value = '';
                    }
                } else {
                    // API error
                    barcodeValidated = false;
                    barcodeInput.classList.remove('is-valid');
                    barcodeInput.classList.add('is-invalid');
                    barcodeFeedback.textContent = data.message || 'Error validating barcode';
                    barcodeFeedback.className = 'invalid-feedback d-block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button state
                validateBarcodeBtn.disabled = false;
                validateBarcodeBtn.innerHTML = '<i class="fas fa-search"></i> {{ __("Validate") }}';

                // Mark barcode as not validated
                barcodeValidated = false;

                // Show error message
                barcodeInput.classList.remove('is-valid');
                barcodeInput.classList.add('is-invalid');
                barcodeFeedback.textContent = 'Network error. Please try again.';
                barcodeFeedback.className = 'invalid-feedback d-block';
            });
        }

        // Add event listeners for barcode validation
        validateBarcodeBtn.addEventListener('click', function() {
            const barcode = barcodeInput.value.trim();
            if (barcode) {
                validateBarcode(barcode);
            }
        });

        // Validate barcode when pressing Enter in the barcode field
        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Prevent form submission
                const barcode = barcodeInput.value.trim();
                if (barcode) {
                    validateBarcode(barcode);
                }
            }
        });

        // Reset validation state when barcode is changed
        barcodeInput.addEventListener('input', function() {
            barcodeValidated = false;
        });

        // --- End Barcode Validation and Autofill ---
    });
</script>
@endsection
