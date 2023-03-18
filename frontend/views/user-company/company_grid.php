<?php
use yii\helpers\Html;
?>

<div class="form-group" style="margin-bottom: 20px;">
    <div class="row">
        <div class="col-sm-9">
        </div>
        <div class="col-sm-3">
            <input type="text" class="form-control" name="search" placeholder="Search Company Name.." id="search-input">
        </div>
    </div>
</div>


<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact Info</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Number of Students</th>
            <th>Zoom In</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<!-- JavaScript code goes here -->
<?php
$this->registerJs("

function loadCompanyData(search='')
{
    $.ajax({
        url: 'map-data?search=' + search,
        dataType: 'json',
        success: function(data) {
            var rows = '';
            $.each(data, function(i, item) {
                rows += '<tr>' +
                        '<td>' + item.id + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + item.address + '</td>' +
                        '<td>' + item.contact_info + '</td>' +
                        '<td>' + item.latitude + '</td>' +
                        '<td>' + item.longitude + '</td>' +
                        '<td>' + item.count_students + '</td>' +
                        '<td><button class=\"btn btn-primary zoom-in-btn\">Zoom In</button></td>' +
                        '</tr>';
            });
            $('table tbody').html(rows);

            // listen for mouseover event on each row
            $('table tbody tr').on('mouseover', function() {
                var selected_company_name = $(this).find('td:eq(1)').text();
                var selected_company_address = $(this).find('td:eq(2)').text();
                var selected_contact_info = $(this).find('td:eq(3)').text();
                var selected_no_of_students = $(this).find('td:eq(6)').text();

                var latitude = $(this).find('td:eq(4)').text();
                var longitude = $(this).find('td:eq(5)').text();
                $('#lat').val(latitude);
                $('#lng').val(longitude);

                $('#selected_company_name').val(selected_company_name);
                $('#selected_company_address').val(selected_company_address);
                $('#selected_contact_info').val(selected_contact_info);
                $('#selected_no_of_students').val(selected_no_of_students);
            });

            // listen for click event on each Zoom In button
            $('table tbody tr .zoom-in-btn').on('click', function() {
                $(\"#go\").click();
            });
        }
    });
}

loadCompanyData('');

$('#search-input').on('input', function() {
    var search = $(this).val();

    loadCompanyData(search);
    
});
");
?>
