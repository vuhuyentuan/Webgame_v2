
<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="package_tab" data-toggle="pill" href="#package_tab" data-toggle="tab">{{ __('Package game') }}</a>
        </li>
    </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            @include('admin.packages.index')
        </div>
    </div>
    <!-- /.card -->
</div>

