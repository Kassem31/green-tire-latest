@extends('layouts.app')

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="page-title">
                <h3>Add Repair Steps</h3>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-8">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('repair-transactions.store') }}" id="repair-form">
                        @csrf

                        <!-- Inspection Transaction Details -->
                        <div class="form-group mb-4">
                            <h5>Inspection Transaction Details:</h5>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <p><strong>{{ __('Barcode') }}:</strong> {{ $inspectionTransaction->barcode }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>{{ __('Tire Type') }}:</strong> {{ $inspectionTransaction->tireType->name_en }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>{{ __('Decision') }}:</strong> {{ $inspectionTransaction->decision }}</p>
                                </div>
                            </div>

                            <input type="hidden" name="inspection_transaction_id" value="{{ $inspectionTransaction->id }}">
                        </div>

                        <!-- Repair Steps Selection -->
                        <div class="form-group mb-4" id="repair-steps-section">
                            <label for="repair_step">Repair Steps:</label>
                            <div class="row mb-3 align-items-end">
                                <div class="col-md-10">
                                    <select class="form-control" id="repair_step">
                                        <option value="">{{ __('Select a repair step') }}</option>
                                        @foreach($repairSteps as $step)
                                            <option value="{{ $step->id }}" data-name="{{ $step->name_en }}">{{ $step->name_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary" id="add-step-btn">
                                        <i class="fas fa-plus"></i> {{ __('Add') }}
                                    </button>
                                </div>
                            </div>

                            <div class="selected-steps mt-4">
                                <h6>{{ __('Selected Steps') }}:</h6>
                                <ul class="list-group" id="selected-steps-list">
                                    <!-- Selected steps will be added here -->
                                </ul>
                            </div>
                        </div>

                        <!-- Final Decision -->
                        <div class="form-group mb-4">
                            <label>Final Decision:</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_repair" value="repair" checked>
                                    <label class="form-check-label" for="decision_repair">
                                        {{ __('Repair') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_scrap" value="scrap">
                                    <label class="form-check-label" for="decision_scrap">
                                        {{ __('Scrap') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="decision" id="decision_pending" value="pending">
                                    <label class="form-check-label" for="decision_pending">
                                        {{ __('Pending') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <a href="{{ route('inspection-transactions.index') }}" class="btn btn-secondary">{{ __('Back to List') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Save Repair Transaction') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addStepBtn = document.getElementById('add-step-btn');
        const repairStepSelect = document.getElementById('repair_step');
        const selectedStepsList = document.getElementById('selected-steps-list');
        const repairForm = document.getElementById('repair-form');
        const repairStepsSection = document.getElementById('repair-steps-section');

        // Add repair step to the list
        addStepBtn.addEventListener('click', function() {
            const stepId = repairStepSelect.value;
            const stepName = repairStepSelect.options[repairStepSelect.selectedIndex].dataset.name;

            if (!stepId) {
                alert('Please select a repair step');
                return;
            }

            //TODO
            // Check if step is already added
          //  if (document.querySelector(`input[value="${stepId}"]`)) {
            //    alert('This repair step has already been added');
              //  return;
            //}

            // Create list item
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.dataset.stepId = stepId;

            // Create step name and hidden input
            const stepText = document.createElement('span');
            stepText.textContent = stepName;

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'repair_steps[]';
            hiddenInput.value = stepId;

            // Create remove button
            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-sm btn-danger';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.type = 'button';
            removeBtn.addEventListener('click', function() {
                li.remove();
            });

            // Append elements
            li.appendChild(stepText);
            li.appendChild(hiddenInput);
            li.appendChild(removeBtn);
            selectedStepsList.appendChild(li);

            // Reset select
            repairStepSelect.value = '';
        });

        // // Handle decision change
        // document.querySelectorAll('input[name="decision"]').forEach(radio => {
        //     radio.addEventListener('change', function() {
        //         if (this.value === 'repair') {
        //             repairStepsSection.style.display = 'block';
        //         } else {
        //             repairStepsSection.style.display = 'none';
        //         }
        //     });
        // });

        // Form submission validation
        repairForm.addEventListener('submit', function(event) {
            const decision = document.querySelector('input[name="decision"]:checked').value;

            if (decision === 'repair') {
                const stepInputs = document.querySelectorAll('input[name="repair_steps[]"]');
                if (stepInputs.length === 0) {
                    event.preventDefault();
                    alert('Please add at least one repair step for repair decision');
                }
            }
        });
    });
</script>
@endpush
@endsection
