function Schedules() {
    var table;
    this.init = function () {
        table = this.table();
        $("#btnNew").click(this.new);
        $("#btnSave").click(this.save);
        $("#btnNewDetail").click(function () {
            $("#frmDetail #schedule_id").val($("#frm #id").val());
            $("#frmModalDetail").modal("show");
            $(".input-detail").cleanFields();
        });
        $('#hour').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });


        $("#btnAddDetail").click(this.saveDetail);
    }

    this.new = function () {
        $(".input-schedules").cleanFields();
        $(".input-detail").cleanFields();
        $("#tblDetail tbody").empty();
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';

        var validate = $(".input-schedules").validate();

        if (validate.length == 0) {
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
                        $(".input-schedules").setFields({data: data.header});
                        table.ajax.reload();
                        toastr.success("ok");
                        $("#btnNewDetail").attr("disabled",false);
                    }
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }
    this.saveDetail = function () {
        toastr.remove();
        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frmDetail #id").val();
        var msg = '';

        var validate = $(".input-detail").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "schedules/detail";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "schedules/detail/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: url,
                method: method,
                data: data,
                dataType: 'JSON',
                success: function (data) {
                    if (data.success == true) {
                        $("#frmModalDetail").modal("hide");
                        $(".input-schedules").setFields({data: data});
                        obj.setTableDetail(data.detail);
                        toastr.success(msg);
                    }
                }
            })
        } else {
            toastr.error("Fields Required!");
        }
    }

    this.edit = function (id) {
        var frm = $("#frmEdit");
        var data = frm.serialize();
        var url = "/schedules/" + id + "/edit";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $('#myTabs a[href="#management"]').tab('show');
                $(".input-schedules").setFields({data: data.header});
                obj.setTableDetail(data.detail);

            }
        })
    }

    this.setTableDetail = function (detail) {
        var html = "";
        $("#tblDetail tbody").empty();
        $.each(detail, function (i, val) {
            html += "<tr><td>" + val.course + "</td>";
            html += "<td>" + val.daytext + "</td>";
            html += "<td>" + val.duration + "</td><td>" + val.hour + "</td>";
            html += "<td>";
            html += '<button class="btn btn-danger btn-xs" onclick=obj.deleteItem(' + val.id + ',' + val.schedule_id + ')>Del</button> ';
            html += '<button class="btn btn-success btn-xs" onclick=obj.editItem(' + val.id + ')>Edit</button>';
            html += "</td>";
            html += "</tr>";
        })
        $("#tblDetail tbody").html(html);
    }


    this.editItem = function (id) {
        var frm = $("#frmDetail");
        var data = frm.serialize();
        var url = "/schedules/" + id + "/editDetail";

        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $("#frmModalDetail").modal("show");
                $(".input-detail").setFields({data: data});
            }
        })
    }


    this.deleteItem = function (id, schedule_id) {
        toastr.remove();
        var par = {};
        par.schedule_id = schedule_id;
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/schedules/detail/" + id;
            $.ajax({
                url: url,
                headers: {'X-CSRF-TOKEN': token},
                method: "DELETE",
                dataType: 'JSON',
                data: par,
                success: function (data) {
                    if (data.success == true) {
                        obj.setTableDetail(data.detail);
                        toastr.warning("Ok");
                    }
                }, error: function (err) {
                    toastr.error("No se puede borrra Este registro");
                }
            })
        }
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
            ajax: "/api/listSchedules",
            columns: [
                {data: "id"},
                {data: "description"},
            ],
            order: [[1, 'ASC']],
            aoColumnDefs: [
                {
                    aTargets: [0, 1],
                    mRender: function (data, type, full) {
                        return '<a href="#" onclick="obj.edit(' + full.id + ')">' + data + '</a>';
                    }
                },
                {
                    targets: [2],
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