function Programation() {
    var table;
    this.init = function () {
        $('#hour').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });

        $("#month_id").change(this.reload);

        $("#btnAddMessage").click(this.saveMessage)
    }

    this.add = function (id, day, year, month) {
        $(".input-programation").cleanFields();
        $("#modalCourse").modal("show");
        
        month = (month <= 9) ? '0' + month : month;
        $("#frm #date").val(month + "-" + day + "-" + year);
        $("#frm #day_id").val(id);
    }

    this.saveMessage = function () {
        var id = $("#frmMessage #row_id").val();
        var token = $("input[name=_token]").val();

        $.ajax({
            url: "setMessage/" + id,
            method: "PUT",
            data: {message: $("#frmMessage #message").val()},
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'JSON',
            success: function (data) {
                if (data.status == true) {
                    $("#modalMessage").modal("hide");
                    toastr.success("Success");
                }
            }
        }
        );
    }

    this.addMessage = function (id) {
        $("#modalMessage").modal("show");
        $("#frmMessage #row_id").val(id);

        $.ajax({
            url: "getMessage/" + id,
            method: "get",
            dataType: 'JSON',
            success: function (data) {
                if (data.data.message != '') {
                    $("#frmMessage #message").text(data.data.message);
                } else {
                    $("#frmMessage #message").text("");
                }

            }
        })

    }

    this.edit = function (id) {
        $("#modalCourse").modal("show");


        $.ajax({
            url: PATH+"/getProgramation/" + id,
            method: "get",
            dataType: 'JSON',
            success: function (data) {
                $(".input-programation").setFields({data: data.data});
            }
        })

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
                $.each(data.days, function (i, val) {
                    html += "<tr align='center'>";
                    for (var i = 1; i <= 7; i++) {
                        var cont = 0;
                        $.each(val.week, function (j, value) {

                            if (value.number_week == i) {
                                cont++;
                                html += '<td style="padding-top: 4%;padding-bottom: 4%;cursor: pointer">';

                                if (data.day == 0) {
                                    html += '<span style="background-color: green" class="badge" onclick="obj.add(' + value.id + ',' + value.day + ',' + value.year + ',' + value.month + ')">'
                                    html += value.day + ' <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>';
                                } else {

                                    if (value.day < data.day) {
                                        html += '<span class="badge">' + value.day + '</span>';
                                    } else {
                                        html += '<span style="background-color: green" class="badge" onclick="obj.add(' + value.id + ',' + value.day + ',' + value.year + ',' + value.month + ')">'
                                        html += value.day + '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></span>';
                                    }


                                }

                                if (value.detail != undefined) {
                                    html += '<ul class="list-group">'
                                    $.each(value.detail, function (k, val2) {
                                        html += '<li class="list-group-item" style="font-size: 10px"><a href="#" onclick="obj.edit('+val2.id+')">#' + val2.id + ' ' + val2.location + '<br>' + val2.course+'</a>'
                                        html += '<span class="badge" onclick="obj.delete(' + val2.id + ')">X</span>'
                                        html += '<span class="badge" onclick="obj.addMessage('+val2.id+')"><span class="glyphicon glyphicon-comment"  aria-hidden="true"></span></span>'
                                        html += '<span class="badge" onclick="obj.edit('+val2.id+')"><span class="glyphicon glyphicon-edit"  aria-hidden="true"></span></span></li>'
                                    })
                                    html += '</ul>'
                                }
                                html += '</td>'
//                                }
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
                    if (data.status == true) {
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