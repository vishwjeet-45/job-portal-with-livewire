<div>

    <!-- Flash Message -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Button -->


    <!-- Employment List -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">

                <span>
                    <strong>Employment</strong>
                </span>
                <a class="add_profile_details text-decoration-none" wire:click="openAddModal" style="cursor:pointer">
                    Add Employment
                </a>
            </div>

            <table class="table skillTable">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Job Title</th>
                        <th>Joining Date</th>
                        <th>Current?</th>
                        <th>Notice</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($employments as $emp)
                        <tr>
                            <td>{{ $emp->company_name }}</td>
                            <td>{{ $emp->job_title }}</td>
                            <td>{{ $emp->joining_date }}</td>
                            <td>{{ ucfirst($emp->is_current) }}</td>
                            <td>{{ $emp->expected_notice }}</td>
                            <td>
                                <button class="btn btn-link p-0 text-primary" wire:click="openEditModal({{ $emp->id }})">Edit</button>
                                <button class="btn btn-link p-0 text-danger" wire:click="deleteEmployment({{ $emp->id }})">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">No Employment Added</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="employmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $mode == 'create' ? 'Add Employment' : 'Edit Employment' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted mb-3">Details like job title, company name, etc, help employers understand your work</p>

                    <div class="row g-3">
                        <!-- company -->
                        <div class="col-md-6">
                            <label class="form-label">company name*</label>
                            <input type="text" wire:model="company_name" class="form-control">
                            @error('company_name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- job title -->
                        <div class="col-md-6">
                            <label class="form-label">job title*</label>
                            <input type="text" wire:model="job_title" class="form-control">
                            @error('job_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- joining date -->
                        <div class="col-md-6">
                            <label class="form-label">Joining Date *</label>
                            <input type="date" wire:model="joining_date" class="form-control">
                            @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- current employment -->
                        <div class="col-md-6">
                            <label class="form-label">Is this your current employment? *</label>
                            <div class="d-flex gap-4">
                                <label><input type="radio" wire:model="is_current" value="yes"> Yes</label>
                                <label><input type="radio" wire:model="is_current" value="no"> No</label>
                            </div>
                        </div>

                        <!-- expected -->
                        <div class="col-md-6">
                            <label class="form-label">Expected Notice*</label>
                            <input type="text" wire:model="expected_notice" class="form-control">
                            @error('expected_notice') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>

                    @if ($mode == 'create')
                        <button class="btn btn-primary" wire:click="saveEmployment">Save</button>
                    @else
                        <button class="btn btn-primary" wire:click="updateEmployment">Update</button>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

<!-- Modal Control -->
<script>
    window.addEventListener('show-employment-modal', () => {
        new bootstrap.Modal(document.getElementById('employmentModal')).show();
    });

    window.addEventListener('hide-employment-modal', () => {
        bootstrap.Modal.getInstance(document.getElementById('employmentModal')).hide();
    });
</script>
