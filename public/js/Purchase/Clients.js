function Clients() {
    var table;
    this.init = function () {

        var location = [], courses = [], dates = [];
        $("input[name='locations[]']:checked").each(function () {
            location.push($(this).val());
        })
        $("input[name='courses[]']:checked").each(function () {
            courses.push($(this).val());
        })

        $("input[name='dates[]']:checked").each(function () {
            dates.push({value: $(this).val(), year: $(this).attr("year")});
        })

        table = this.table(location, courses, dates);

        $("#new").click(this.save);
        $("#edit").click(this.edit);
        $("#btnNew").click(function () {
            $(".input-courses").cleanFields();
            $("#modalNew").modal("show");
        });

        $(".input-locations").click(function () {
            obj.reload();
        })

        $(".input-courses").click(function () {
            obj.reload();
        })

        $(".input-dates").click(function () {
            obj.reload();
        })

    }

    this.reload = function () {
        var location = [], courses = [], dates = [];
        $("input[name='locations[]']:checked").each(function () {
            location.push($(this).val());
        })
        $("input[name='courses[]']:checked").each(function () {
            courses.push($(this).val());
        })

        $("input[name='dates[]']:checked").each(function () {
            dates.push({value: $(this).val(), year: $(this).attr("year")});
        })

        obj.table(location, courses, dates);
    }

    this.save = function () {
        toastr.remove();
        var frm = $("#frm");
        var data = frm.serialize();
        var url = "", method = "";
        var id = $("#frm #id").val();
        var msg = '';
        var validate = $(".input-courses").validate();
        if (validate.length == 0) {
            if (id == '') {
                method = 'POST';
                url = "courses";
                msg = "Created Record";
            } else {
                method = 'PUT';
                url = "courses/" + id;
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
                        $(".input-courses").setFields({data: data});
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
        var url = "/courses/" + id + "/edit";
        $("#modalNew").modal("show");
        $.ajax({
            url: url,
            method: "GET",
            data: data,
            dataType: 'JSON',
            success: function (data) {
                $(".input-courses").setFields({data: data});
            }
        })
    }

    this.delete = function (id) {
        toastr.remove();
        if (confirm("Deseas eliminar")) {
            var token = $("input[name=_token]").val();
            var url = "/courses/" + id;
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

    this.table = function (location_id = 0, course_id = 0, start_date = 0) {
        var param = {};
        param.location = location_id;
        param.courses = course_id;
        param.start_date = start_date;

        $.ajax({
            url: PATH + "/clients/getList",
            method: "get",
            data: param,
            dataType: 'JSON',
            beforeSend: function () {
                $("#loading-super").removeClass("hidden");
            },
            success: function (data) {
                if (data.success == true) {

                    obj.setList(data.data);
                    $("#loading-super").addClass("hidden");
                }
            }, error: function (err) {

            }
        })
    }

    this.setList = function (data) {
        var html = "", rowspan = 0, j = 0;
        if (data.length > 0) {


            $.each(data, function (i, father) {

                $.each(father, function (i, val) {
                    html += '<div class="panel panel-yellow">';
                    html += '<div class="panel-heading">';
                    html += '<div class="row"><div class="col-lg-5">' + val.course + '</div><div class="col-lg-4">' + val.location + '</div></div>';
                    html += '</div>'
                    html += '<table class="table table-condensed" style="wdth:100%">'
                    rowspan = 2;
//                        rowspan = val[i].length;

                    $.each(val.node, function (i, value) {
                        value.message = (value.message == null) ? '' : "<br><strong>" + value.message + "</strong>";
                        if (i == 0) {
                            value.phone = (value.phone == null) ? '' : value.phone;
                            html += '<tr>';
                            html += '<td align="left" width="40%"> ';
                            html += value.dateFormated + '.....' + value.hour + ' - ' + value.hour_end + '</td>';
                            html += '<td rowspan="' + rowspan + '" align="center">' + value.address + '<br>Phone <a href="tel:' + value.phone + '"> ' + value.phone + '</a>' + value.message + '</td>';
                            html += '<td rowspan="' + rowspan + '" align="center"><a class="btn btn-primary" href="' + PATH + '/clients/' + val.id + '">Register</button></td>';
                            html += '</tr>'
                        } else {
                            html += '<tr>';
                            html += '<td align="left"> ';
                            html += value.dateFormated + '.....' + value.hour + ' - ' + value.hour_end + '</td>';
                            html += '</tr>'
                        }
                    });
                    html += '</table></div>';
                })










//



            })
        } else {
            html = '<div class="alert alert-warning">No se encontro Programación</div>';
        }


        $("#content-list").html(html);
    }

}

var obj = new Clients();
obj.init();