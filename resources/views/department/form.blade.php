<div class="card-body">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">{{__($department->name)}}</h3>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col">{{__('Delete')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department->users as $user)
                            <tr>
                                <th scope="row">
                                    {{__($user->first_name.' '.$user->last_name)}}
                                </th>
                                <td>
                                    <a href="{{route('department.remove',[$user->id,$department->id])}}">
                                        <button class='btn btn-danger'>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </a>
                                    <a href="{{route('department.lead',[$user->id,$department->id])}}">
                                        <button class='btn btn-danger'>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        
    <form method="POST" action="{{ route('department.store') }}" autocomplete="off">
        @csrf
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-12'>
                    <label for="user_id" style='margin-top:30px'>{{__('Add user')}}</label>
                    <select name="user_id" class="custom-select" >
                        @foreach($allusers as $user)
                            <option value="{{__($user->id)}}">{{__($user->first_name.' '.$user->last_name)}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="department_id" name="department_id" value="{{__($department->id)}}">
                    <div class="text-center">
                            <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>