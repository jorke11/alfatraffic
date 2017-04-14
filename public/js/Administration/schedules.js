function Schedules() {
    var table, day = {1: "monday", 2: "tuesday", 3: "wednesday", 4: "thurday", 5: "friday", 6: "saturday", 6: "sunday"};
    this.init = function () {
//        table = this.table();
        this.tableSchedule();
        $("#btnNew").click(this.save);

        $('#hour').datetimepicker({
            datepicker: false,
            format: 'H:i',
        });
    }

    this.loadDay = function (day) {
        this.tableSchedule(day);
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        if ($("#frm #course_id").val() != 0) {
            if ($("#frm #location_id").val() != 0) {
                if (id == '') {
                    method = 'POST';
                    url = "schedules";
                    msg = "Created Record";
                } else {
                    method = 'PUT';
                    url = "schedules/" + id;
                    msg = "Edited Record";
                }

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.success == true) {
                            toastr.success(msg);
                            console.log(data.data);
                            obj.setTable(data.data);
                        }
                    }
                })
            } else {
                toastr.error("location is required");
            }
        } else {
            toastr.error("course is required");
        }

    }

    this.tableSchedule = function (day = $('input[name=day]:checked', '#frm').val()) {
        $.ajax({
            url: "schedules/getTable/" + day + "/" + $("#frm #course_id").val() + "/" + $("#frm #location_id").val(),
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                if (data.success == true) {
                    obj.setTable(data.data);
                }
            }
        })
    }

    this.setTable = function (data) {
        var html = "", days_week = '';
        $("#tbl tbody").empty();
        
        
        
        if (data.length > 0) {
            $.each(data, function (i, val) {
                $.each(day, function (j, value) {
                    if (j == val.day) {
                        days_week = value;
                    }
                });

                html += "<tr><td>" + days_week + "</td><td>" + val.location + "</td><td>" + val.course + "</td><td>" + val.hour + "</td>";
                html += '<td><button class="btn btn-danger btn-xs" onclick=obj.delete(' + val.id + ')><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td></tr>';
            })
        } else {
            html = '<tr align="center"><td colspan="5"><b>No records found</b></td></tr>';
        }
        $("#tbl tbody").html(html);
    }

    this.show = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/schedules/" + id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-schedules").setFields({data: data});
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/schedules/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        obj.setTable(data.data);
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
    }

    this.table = function () {
        var param = {};
        param.course_id = $("#frm #course_id").val();
        param.day = $("#frm #day").val();

        return $('#tbl').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/api/listSchedules",
                method: 'GET',
                data: param,
            },
            columns: [
                {data: "id"},
                {data: "day"},
                {data: "course_id"},
                {data: "hour"},
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
                    targets: [4],
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

var obj = new Schedules();
obj.init();