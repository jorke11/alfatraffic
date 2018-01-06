function events() {
    var table;
    this.init = function () {
        table = this.table();
        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#btnNew").click(function () {
            $(".input-events").cleanFields();
            $("#modalNew").modal("show");
        });

        $('#dateevent').datetimepicker({
            timepicker: false,
            format: 'Y-m-d'
        });

        $("#location_id").change(this.dayslocation);

    }

    this.dayslocation = function () {
        $(this).val();

        var url = "/schedules/" + $(this).val() + "/getModal";
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                var html = "";
                html += "<option value='0'>Seleccione</option>";
                $.each(data.courses, function (i, val) {
                    html += "<option value='" + val.id + "'>" + val.description + "</option>";
                })
                $("#course_id").html(html);
                html = "";
                html += "<option value='0'>Seleccione</option>";
            }
        })

    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-events").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "events";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "events/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#modalNew").modal("hide");
                        $(".input-events").setFields({data: data});
                        table.ajax.reload();
                        toastr.success(msg);
                    }
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.show = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/events/" + id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-events").cleanFields();
                $(".input-events").setFields({data: data});
                $("#days").val(data.days).trigger('change');
                $("#courses").val(data.courses).trigger('change');
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/events/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        table.ajax.reload();
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.table = function () {
        return $('#tbl').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/api/listEvents",
            columns: [
                {data: "id"},
                {data: "description"},
                {data: "course_id"},
                {data: "location_id"},
                {data: "dateevent"},
                {data: "action_id"},
                {data: "status_id"}
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1, 2, 3],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.show(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [7],
                    searchable: false,
                    mData: null,
                    mRender: function (data, type, full) {
                        return '<button class="btn btn-danger btn-xs" onclick="obj.delete(' + data.id + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
                    }
                }
            ],
        });
    }

}

var obj = new events();
obj.init();