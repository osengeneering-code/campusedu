@extends('layouts.admin')

@section('content')


 <div class="container-xxl flex-grow-1 container-p-y">
          
  <h4 class="mb-1"><b>GESTION DES ROLES DES UTILISATEURS</b></h4>

  <p class="mb-6">A role provided access to predefined menus and features so that depending on assigned role an administrator can have access to what user needs.</p>
  <!-- Role cards -->
  <div class="row g-6">
    @foreach($roles as $role)
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="fw-normal mb-0 text-body">Total {{ $role->users->count() }} users</h6>
            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                @foreach($role->users->take(5) as $user)
              <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="{{ $user->name }}" class="avatar pull-up">
                <img class="rounded-circle" src="{{ $user->profile_photo_url ? asset($user->profile_photo_url) : asset('images/logo.png') }}" alt="Avatar" />
              </li>
                @endforeach
                @if($role->users->count() > 5)
              <li class="avatar">
                <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $role->users->count() - 5 }} more">+{{ $role->users->count() - 5 }}</span>
              </li>
                @endif
            </ul>
          </div>
<div class="d-flex justify-content-between align-items-end">
            <div class="role-heading">
              <h5 class="mb-1">{{ $role->name }}</h5>
            </div>
            <div class="d-flex align-items-center">
                <a href="{{ route('roles.edit', $role->id) }}" class="me-2">
                    <i class="icon-base bx bx-edit icon-md text-body-secondary"></i>
                </a>
                <a href="javascript:void(0);" class="me-2"><i class="icon-base bx bx-copy icon-md text-body-secondary"></i></a>
                <a href="javascript:;" class="text-danger delete-role" data-bs-toggle="modal" data-bs-target="#deleteRoleModal-{{ $role->id }}"><i class="bx bx-trash"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Role Modal -->
    <div class="modal fade" id="deleteRoleModal-{{ $role->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-simple modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body text-center">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <h4 class="mb-2">Confirmer la suppression</h4>
            <p>Êtes-vous sûr de vouloir supprimer ce rôle ?</p>
            <p>En supprimant se role,vous risqué de bloqué la possibilité d'autres utilisateurs d'acceder a leurs données!</p>
            <form id="deleteRoleForm-{{ $role->id }}" method="POST" action="{{ route('roles.destroy', $role->id) }}" class="text-end">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger me-sm-3 me-1">Confirmer</button>
              <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Annuler</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    <div class="col-xl-4 col-lg-6 col-md-6">
      <div class="card h-100">
        <div class="row h-100">
          <div class="col-sm-5">
            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4 ps-6">
              <img src="{{ asset('Pro/assets/img/illustrations/man-with-laptop.png') }}" class="img-fluid" alt="Image" width="120" />
            </div>
          </div>
          <div class="col-sm-7">
            <div class="card-body text-sm-end text-center ps-sm-0">
              <button data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Ajouter un nouveau role</button>
              <p class="mb-0">
                Ajouter un nouveau role,si il n'existe pas <br />
                .
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-12">
      <!-- Role Table -->
      <div class="card">
        <div class="card-datatable">
          <table class="datatables-users table border-top table-responsive">
            <thead>
              <tr>
                <th>Photo et Utilisateur</th>
                <th>email</th>
                <th>Role</th>
                <th>entreprise</th>
                <th>Status</th>
                <th>Téléphone</th>
              </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <img src="{{ $user->profile_photo_url ? asset($user->profile_photo_url) : asset('images/logo.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                        <span>{{ $user->nom }} {{ $user->prenom }}</span>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach ($user->roles as $role)
                            <span class="badge bg-label-info me-1">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $user->entreprise->nom ?? 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $user->statut === 'actif' ? 'bg-label-success' : 'bg-label-danger' }} me-1">
                            <i class="icon-base bx {{ $user->statut === 'actif' ? 'bx-check-circle' : 'bx-lock-alt' }} me-1"></i>
                            {{ $user->statut }}
                        </span>
                    </td>
                    <td>{{ $user->telephone }}</td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!--/ Role Table -->
    </div>
  </div>
  <!--/ Role cards -->

  <!-- Add Role Modal -->
  <!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="role-title mb-2">Ajouter un nouveau role</h4>
          <p>Assignée des permissions</p>
        </div>
        <!-- Add role form -->
        <form id="addRoleForm" class="row g-6" method="POST" action="{{ route('roles.store') }}">
    @csrf
    <input type="hidden" name="_method" value="POST">
          <div class="col-12 form-control-validation">
            <label class="form-label" for="modalRoleName">Role Name</label>
            <input type="text" id="modalRoleName" name="name" class="form-control" placeholder="Enter a role name" tabindex="-1" />
          </div>
          <div class="col-12">
            <h5 class="mb-6">Role Permissions</h5>
            <!-- Permission table -->
            <div class="table-responsive">
              <table class="table table-flush-spacing mb-0 border-top">
                <tbody>
                  <tr>
                    <td class="text-nowrap fw-medium text-heading">Administrator Access <i class="icon-base bx bx-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i></td>
                    <td>
                      <div class="d-flex justify-content-end">
                        <div class="form-check mb-0">
                          <input class="form-check-input" type="checkbox" id="selectAll" />
                          <label class="form-check-label" for="selectAll"> Select All </label>
                        </div>
                      </div>
                    </td>
                  </tr>
                  @php
                  $groupedPermissions = $permissions->groupBy(function($item, $key){
                    return explode(' ', $item->name)[0];
                  });
                  @endphp
                  @foreach($groupedPermissions as $groupName => $permissionGroup)
                  <tr>
                    <td class="text-nowrap fw-medium text-heading">{{ ucfirst($groupName) }}</td>
                    <td>
                      <div class="d-flex justify-content-end">
                        @foreach($permissionGroup as $permission)
                        <div class="form-check mb-0 me-4 me-lg-12">
                          <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}" name="permissions[]" value="{{ $permission->name }}" />
                          <label class="form-check-label" for="permission-{{ $permission->id }}"> {{ explode(' ', $permission->name)[1] ?? 'access' }} </label>
                        </div>
                        @endforeach
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- Permission table -->
          </div>
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer le role</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
        <!--/ Add role form -->
      </div>
    </div>
  </div>
</div>
<!--/ Add Role Modal -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const addRoleModal = document.getElementById('addRoleModal');
    const addRoleForm = document.getElementById('addRoleForm');
    const modalRoleName = document.getElementById('modalRoleName');
    const roleTitle = addRoleModal.querySelector('.role-title');
    const selectAll = document.getElementById('selectAll');
    const permissionsCheckboxes = document.querySelectorAll('input[name="permissions[]"]');

    addRoleModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const isEdit = button.classList.contains('role-edit-modal');

        // Reset form for new role
        if (!isEdit) {
            roleTitle.textContent = 'Ajouter un nouveau role';
            modalRoleName.value = '';
            addRoleForm.action = '{{ route("roles.store") }}';
            // Ensure _method is POST for new roles
            let methodInput = addRoleForm.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.value = 'POST';
            } else {
                methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'POST');
                addRoleForm.appendChild(methodInput);
            }
            permissionsCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAll.checked = false;
        }
    });

    // Handle "Edit Role" button click
    document.querySelectorAll('.role-edit-modal').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role-id');
            const roleName = this.getAttribute('data-role-name');
            const rolePermissions = JSON.parse(this.getAttribute('data-role-permissions'));

            roleTitle.textContent = 'Modifier le rôle';
            modalRoleName.value = roleName;
            addRoleForm.action = '{{ route("roles.update", ":id") }}'.replace(':id', roleId);
            
            // Set _method to PUT for updates
            let methodInput = addRole-form.querySelector('input[name="_method"]');
            if (methodInput) {
                methodInput.value = 'PUT';
            } else {
                methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'PUT');
                addRoleForm.appendChild(methodInput);
            }

            permissionsCheckboxes.forEach(checkbox => {
                checkbox.checked = rolePermissions.includes(checkbox.value);
            });
            selectAll.checked = Array.from(permissionsCheckboxes).every(checkbox => checkbox.checked);
        });
    });


    selectAll.addEventListener('change', function () {
        permissionsCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    });
    
});
</script>
@endpush