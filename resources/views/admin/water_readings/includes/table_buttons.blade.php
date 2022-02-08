<a href="{{ route('admin.water_reading-edit',$id) }}" type="button" class="btn btn-primary table-btn mr-2 mb-2 mb-sm-0">
    <app-icon name="edit" />
</a>
<a href="{{ route('admin.water_reading-delete',$id) }}" onclick="return confirm('Are you sure you want to delete this record?')" type="button" class="btn btn-danger table-btn mr-2 mb-2 mb-sm-0">
    <app-icon name="trash-2" />
</a>
<a href="{{ route('admin.get_reading_info',$id) }}" type="button" class="btn btn-info table-btn mr-2 mb-2 mb-sm-0">
    <app-icon name="download" />
</a>