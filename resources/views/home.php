<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="<?= csrf_token() ?>">

    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <style type="text/css">
        .text-success {
            color: green;
        }
        .text-error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div id="app-1">
                <table>
                    <tr colspan="3">Заполните матрицу значениями</tr>
                    <tr>
                        <td><input v-model="a11" placeholder="a11"></td>
                        <td><input v-model="a12" placeholder="a12"></td>
                        <td><input v-model="a13" placeholder="a13"></td>
                    </tr>
                    <tr>
                        <td><input v-model="a21" placeholder="a21"></td>
                        <td><input v-model="a22" placeholder="a22"></td>
                        <td><input v-model="a23" placeholder="a23"></td>
                    </tr>
                    <tr>
                        <td><input v-model="a31" placeholder="a31"></td>
                        <td><input v-model="a32" placeholder="a32"></td>
                        <td><input v-model="a33" placeholder="a33"></td>
                    </tr>
                </table>
                <br />
                <div id="res" class="text-success"></div>
                <div id="errors" class="text-error"></div>
                <br />
                <button v-on:click="calculateMatrix">Посчитать</button>
            </div>

            <script type="text/javascript">

                var app1 = new Vue({
                    el: '#app-1',
                    data: {
                        a11: '',
                        a12: '',
                        a13: '',
                        a21: '',
                        a22: '',
                        a23: '',
                        a31: '',
                        a32: '',
                        a33: ''
                    },
                    methods: {
                        calculateMatrix: function () {

                            // здравствуй jQuery и прощай Vue
                            $('#res').text('');
                            $('#errors').text('');

                            jQuery.ajax({
                                headers: {
                                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: '/home/calculate-matrix',
                                type: "PATCH",
                                data: {
                                    a11: this.a11,
                                    a12: this.a12,
                                    a13: this.a13,
                                    a21: this.a21,
                                    a22: this.a22,
                                    a23: this.a23,
                                    a31: this.a31,
                                    a32: this.a32,
                                    a33: this.a33
                                },
                                error: function (jqXHR, textStatus, errorThrown)
                                {
                                    var str_errors = '';
                                    if(jqXHR.responseJSON.errors != undefined) {
                                        for (var key in jqXHR.responseJSON.errors) {
                                            var field_errors = jqXHR.responseJSON.errors[key];
                                            for (var key2 in field_errors) {
                                                str_errors += field_errors[key2] + ' ';
                                            }
                                        }
                                    }else {
                                        str_errors = jqXHR.responseJSON.message;
                                    }

                                    $('#errors').text(str_errors);
                                }

                            }).done(function(response)
                            {
                                $('#res')
                                    .text('Сумма главной и побочной диагоналей матрицы равна ' + response.res);
                            });
                        }
                    }
                })
            </script>

    </div>
</div>

</body>
</html>