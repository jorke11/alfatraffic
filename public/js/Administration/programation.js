function Programation() {
    var table;
    this.init = function () {
        $('#hour').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });

        $("#month_id").change(this.reload);
    }

    this.add = function (id, day, year, month) {
        $("#modalCourse").modal("show");
        $("#frm #date").val(day + "-" + month + "-" + year);
        $("#frm #day_id").val(id);
    }

    this.reload = function () {
        $(this).val();
        $("#mount_id").val($(this).val());
        var url = "/programation/" + $(this).val() + "/getMonth";
        $.ajax({
            url: url,
            method: "GET",
            dataType: 'JSON',
            success: function (data) {
                var html = "";
                $("#table-calendar tbody").empty();
                $.each(data, function (i, val) {
                    html += "<tr align='center'>";
                    for (var i = 1; i <= 7; i++) {
                        var cont = 0;
                        $.each(val.week, function (j, value) {

                            if (value.number_week == i) {
                                cont++;
                                html += '<td style="padding-top: 4%;padding-bottom: 4%;cursor: pointer">';
                                html += '<span class="badge" onclick="obj.add(' + value.id + ',' + value.day + ',' + value.year + ',' + value.month + ')">'
                                html += value.day + '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>';
                                if (value.detail != undefined) {
                                    html += '<ul class="list-group">'
                                    $.each(value.detail, function (k, val2) {
                                        html += '<li class="list-group-item" style="font-size: 10px">' + val2.location + '<br>' + val2.course
                                        html += '<span class="badge" onclick="obj.delete({{' + val2.id + ')">X</span></li>'
                                    })
                                    html += '</ul>'
                                }
                                html += '</td>'
                            }


                        })
                        if (cont == 0) {
                            html += '<td></td>';
                        }


                    }
                    html += "</tr>";
                })

                $("#table-calendar tbody").html(html);

            }
        })

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
                $.each(data.days, function (i, val) {
                    html += "<option value='" + val.code + "'>" + val.description + "</option>";
                })
                $("#day").html(html);
            }
        })

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

        var validate = $(".input-programation").validate();

        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "programation";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "programation/" + id;
                msg = "Edited Record";
            }

            $.ajax({
                url: 'programation',
                method: "POST",
                data: data,
                dataType: 'JSON',
                success: function (data) {
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
                $("#btnNewDetail").attr("disabled", false);
                obj.setTableDetail(data.detail);

            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/programation/" + id;
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
}

var obj = new Programation();
obj.init();