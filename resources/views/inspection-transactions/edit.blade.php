@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Edit Inspection Transaction</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
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

                    <form method="POST" action="{{ route('inspection-transactions.update', $inspectionTransaction) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-4">
                            <label for="barcode">Barcode:</label>
                            <div class="input-group">
                                <input id="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror"
                                    name="barcode" value="{{ old('barcode', $inspectionTransaction->barcode) }}" required autofocus>
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
                            <label>Tire Type:</label>
                            <div class="d-flex flex-wrap gap-3">
                                @foreach($tireTypes as $tireType)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tire_type_id"
                                            id="tire_type_{{ $tireType->id }}" value="{{ $tireType->id }}"
                                            {{ old('tire_type_id', $inspectionTransaction->tire_type_id) == $tireType->id ? 'checked' : '' }} required>
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
                            <label for="machine">Machine:</label>
                            <input id="machine" type="text" class="form-control @error('machine') is-invalid @enderror"
                                name="machine" value="{{ old('machine', $inspectionTransaction->machine) }}">
                            @error('machine')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="operator_name">Operator Name:</label>
                            <input id="operator_name" type="text" class="form-control @error('operator_name') is-invalid @enderror"
                                name="operator_name" value="{{ old('operator_name', $inspectionTransaction->operator_name) }}">
                            @error('operator_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="operator_code">Operator Code:</label>
                            <input id="operator_code" type="text" class="form-control @error('operator_code') is-invalid @enderror"
                                name="operator_code" value="{{ old('operator_code', $inspectionTransaction->operator_code) }}">
                            @error('operator_code')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label>Observations:</label>
                            <div class="input-group mb-3">
                                <select id="observation_select" class="form-control">
                                    <option value="">{{ __('Select Observation') }}</option>
                                    @foreach($observations as $observation)
                                        <option value="{{ $observation->id }}" data-name="{{ $observation->name_en }} ({{ $observation->name_ar }})">
                                            {{ $observation->name_en }} ({{ $observation->name_ar }})
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-primary" type="button" id="add_observation">+</button>
                            </div>
                            <div id="selected_observations_container" class="border p-3 rounded mb-3">
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
                            <label>Decision:</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_repair"
                                        value="Repair" {{ old('decision', $inspectionTransaction->decision) == 'Repair' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="decision_repair">{{ __('Repair') }}</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_scrap"
                                        value="Scrap" {{ old('decision', $inspectionTransaction->decision) == 'Scrap' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="decision_scrap">{{ __('Scrap') }}</label>
                                </div>
                            </div>
                            @error('decision')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <a href="{{ route('inspection-transactions.index') }}" class="btn btn-secondary">Back to List</a>
                            <button type="submit" class="btn btn-primary">Update Transaction</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Focus on barcode field initially
        document.getElementById('barcode').focus();

        // Barcode validation
        const barcodeInput = document.getElementById('barcode');
        const validateBarcodeBtn = document.getElementById('validate_barcode');
        const barcodeFeedback = document.getElementById('barcode_feedback');
        const machineInput = document.getElementById('machine');
        const operatorNameInput = document.getElementById('operator_name');
        const operatorCodeInput = document.getElementById('operator_code');
        let barcodeValidated = true; // Initially true because the existing barcode is assumed valid

        // Function to validate barcode using API
        function validateBarcode(barcode) {
            validateBarcodeBtn.disabled = true;
            validateBarcodeBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validating...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

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
                validateBarcodeBtn.disabled = false;
                validateBarcodeBtn.innerHTML = '<i class="fas fa-search"></i> {{ __("Validate") }}';

                if (data.success) {
                    if (data.exists) {
                        barcodeValidated = true;
                        operatorNameInput.value = data.data.operator_name || operatorNameInput.value;
                        operatorCodeInput.value = data.data.operator_code || operatorCodeInput.value;
                        machineInput.value = data.data.machine || machineInput.value;
                        barcodeInput.classList.add('is-valid');
                        barcodeInput.classList.remove('is-invalid');
                        barcodeFeedback.textContent = 'Barcode validated successfully!';
                        barcodeFeedback.className = 'valid-feedback d-block';
                    } else {
                        barcodeValidated = false;
                        barcodeInput.classList.remove('is-valid');
                        barcodeInput.classList.add('is-invalid');
                        barcodeFeedback.textContent = 'Barcode not found in the system. Cannot proceed with this barcode.';
                        barcodeFeedback.className = 'invalid-feedback d-block';
                        operatorNameInput.value = operatorNameInput.value; // Keep existing values
                        operatorCodeInput.value = operatorCodeInput.value;
                        machineInput.value = machineInput.value;
                    }
                } else {
                    barcodeValidated = false;
                    barcodeInput.classList.remove('is-valid');
                    barcodeInput.classList.add('is-invalid');
                    barcodeFeedback.textContent = data.message || 'Error validating barcode';
                    barcodeFeedback.className = 'invalid-feedback d-block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                validateBarcodeBtn.disabled = false;
                validateBarcodeBtn.innerHTML = '<i class="fas fa-search"></i> {{ __("Validate") }}';
                barcodeValidated = false;
                barcodeInput.classList.remove('is-valid');
                barcodeInput.classList.add('is-invalid');
                barcodeFeedback.textContent = 'Network error. Please try again.';
                barcodeFeedback.className = 'invalid-feedback d-block';
            });
        }

        // Add event listeners for barcode validation
        if (validateBarcodeBtn) {
            validateBarcodeBtn.addEventListener('click', function() {
                const barcode = barcodeInput.value.trim();
                if (!barcode) {
                    barcodeInput.classList.add('is-invalid');
                    barcodeFeedback.textContent = 'Please enter a barcode';
                    barcodeFeedback.className = 'invalid-feedback d-block';
                    return;
                }
                validateBarcode(barcode);
            });

            barcodeInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const barcode = barcodeInput.value.trim();
                    if (!barcode) {
                        barcodeInput.classList.add('is-invalid');
                        barcodeFeedback.textContent = 'Please enter a barcode';
                        barcodeFeedback.className = 'invalid-feedback d-block';
                        return;
                    }
                    validateBarcode(barcode);
                }
            });
        }

        // Reset validation state when barcode is changed
        barcodeInput.addEventListener('input', function() {
            if (barcodeInput.value !== '{{ old('barcode', $inspectionTransaction->barcode) }}') {
                barcodeValidated = false;
                barcodeInput.classList.remove('is-valid', 'is-invalid');
                barcodeFeedback.className = 'invalid-feedback d-none';
            }
        });

        // Form validation to ensure barcode is validated
        const form = document.querySelector('form');
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
                barcodeFeedback.textContent = 'Please validate the barcode before submitting';
                barcodeFeedback.className = 'invalid-feedback d-block';
            }
        });

        // Observation selection functionality (keep the existing code)
        const observationSelect = document.getElementById('observation_select');
        const addObservationBtn = document.getElementById('add_observation');
        const selectedObservationsListDiv = document.getElementById('selected_observations_list');
        const observationsError = document.getElementById('observations_error');
        const selectedObservationsContainer = document.getElementById('selected_observations_container');

        function isObservationAdded(id) {
            return !!selectedObservationsListDiv.querySelector(`input[name="observations[]"][value="${id}"]`);
        }

        function addObservationToDiv(id, name) {
            const wrapper = document.createElement('div');
            wrapper.className = 'badge bg-secondary me-2 mb-2 d-flex align-items-center';
            wrapper.style.padding = '0.5em 0.75em';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'observations[]';
            input.value = id;
            wrapper.appendChild(input);

            const span = document.createElement('span');
            span.textContent = name;
            span.className = 'me-2';
            wrapper.appendChild(span);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.innerHTML = '×';
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

        function showError(message) {
            observationsError.textContent = message;
            observationsError.classList.remove('d-none');
            observationsError.classList.add('d-block');
            setTimeout(() => {
                observationsError.classList.remove('d-block');
                observationsError.classList.add('d-none');
            }, 2000);
        }

        function updateContainerVisibility() {
            if (selectedObservationsListDiv.children.length === 0) {
                selectedObservationsContainer.style.display = 'none';
            } else {
                selectedObservationsContainer.style.display = '';
            }
        }

        addObservationBtn.addEventListener('click', function() {
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
        });

        // Decision visibility logic
        const tireTypeRadios = document.querySelectorAll('input[name="tire_type_id"]');
        const decisionRow = document.getElementById('decision_row');
        const decisionRadios = document.querySelectorAll('input[name="decision"]');

        function toggleDecisionVisibility() {
            const selectedTireType = document.querySelector('input[name="tire_type_id"]:checked');
            const greenTireId = '2';
            const isGreenTire = selectedTireType && selectedTireType.value === greenTireId;

            if (isGreenTire) {
                decisionRow.style.display = '';
                decisionRadios.forEach(radio => radio.required = true);
            } else {
                decisionRow.style.display = 'none';
                decisionRadios.forEach(radio => radio.required = false);
                decisionRadios.forEach(radio => radio.checked = false);
            }
        }

        tireTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleDecisionVisibility);
        });

        // Load existing observations
        const initialObservations = @json(old('observations', $selectedObservations ?? []));
        const allObservationsData = @json($observations->keyBy('id'));

        initialObservations.forEach(observationId => {
            const idStr = String(observationId);
            if (allObservationsData[idStr]) {
                const obsData = allObservationsData[idStr];
                if (!isObservationAdded(idStr)) {
                    addObservationToDiv(idStr, `${obsData.name_en} (${obsData.name_ar})`);
                }
            }
        });

        // Initial setup
        updateContainerVisibility();
        toggleDecisionVisibility();
    });
</script>
@endsection