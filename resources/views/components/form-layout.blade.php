{{-- componaent/form-layout.blade.php --}}
@props([
    'title',          // Form title
    'isEdit' => false,
    'submitLabel' => null,
    'backRoute' => null,
])
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card m-0 my-2">
                <div class="card-body p-2">
                    <form wire:submit.prevent="save" enctype="multipart/form-data">
                        {{ $slot }}
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close btn-close btn-white" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close btn-close btn-white" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove>
                                    {{ $submitLabel ?? ($isEdit ? 'Update' : 'Submit') }}
                                </span>
                                <span wire:loading>
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    {{ $isEdit ? 'Updating...' : 'Creating...' }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
