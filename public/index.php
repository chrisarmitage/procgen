<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

</head>
<body>
<div id="app" class="container">

    <div class="row">
        <div class="col s2">

            <div class="input-field col s12">
            <a class="waves-effect waves-light btn" v-on:click="shield.refresh += 1">Refresh</a>
            </div>


            <div class="input-field col s12">
                <div class="switch">
                    <label>
                        Seeded
                        <input type="checkbox" v-model="seeded">
                        <span class="lever"></span>
                    </label>
                </div>
            </div>

            <div class="input-field col s12">
                <select v-model="shield.foreground">
                    <option value="">Random</option>
                    <option disabled>Metals</option>
                    <option value="ffdc0a">Gold</option>
                    <option value="f0f0f0">Silver</option>
                    <option disabled>Colours</option>
                    <option value="0000ff">Blue</option>
                    <option value="ff0000">Red</option>
                    <option value="aa00aa">Purple</option>
                    <option value="000000">Black</option>
                    <option value="009600">Green</option>
                </select>
                <label>Foreground Colour</label>
            </div>


            <div class="input-field col s12">
                <select v-model="shield.background">
                    <option value="">Random</option>
                    <option disabled>Metals</option>
                    <option value="ffdc0a">Gold</option>
                    <option value="f0f0f0">Silver</option>
                    <option disabled>Colours</option>
                    <option value="0000ff">Blue</option>
                    <option value="ff0000">Red</option>
                    <option value="aa00aa">Purple</option>
                    <option value="000000">Black</option>
                    <option value="009600">Green</option>
                </select>
                <label>Background Colour</label>
            </div>

            <div class="input-field col s12">
                <select v-model="shield.fieldType">
                    <option value="">Random</option>
                    <option value="ordinary">Ordinary</option>
                    <option value="party">Party</option>
                    <option value="blank">Blank</option>
                </select>
                <label>Field Type</label>
            </div>

            <div class="input-field col s12">
                <select v-model="shield.ordinary">
                    <option value="">Random</option>
                    <option value="bend">Bend</option>
                    <option value="cross">Cross</option>
                    <option value="pale">Pale</option>
                    <option value="fess">Fess</option>
                    <option value="saltire">Saltire</option>
                    <option value="chevron">Chevron</option>
                    <option value="chief">Chief</option>
                    <option value="paly">Paly</option>
                    <option value="barry">Barry</option>
                    <option value="chequy">Chequy</option>
                    <option value="bendy">Bendy</option>
                    <option value="lozengy">Lozengy</option>
                    <option value="chevronny">Chevronny</option>
                    <option value="bordure">Bordure</option>
                    <option value="orle">Orle</option>
                </select>
                <label>Ordinary Type</label>
            </div>

            <div class="input-field col s12">
                <select v-model="shield.party">
                    <option value="">Random</option>
                    <option value="bend">Bend</option>
                    <option value="cross">Cross</option>
                    <option value="pale">Pale</option>
                    <option value="fess">Fess</option>
                    <option value="saltire">Saltire</option>
                    <option value="chevron">Chevron</option>
                    <option value="gyronny">Gyronny</option>
                </select>
                <label>Party Type</label>
            </div>

            <div class="input-field col s12">
                <select v-model="shield.addCharge">
                    <option disabled>Add Charge</option>
                    <option value="">Random</option>
                    <option value="true">Yes</option>
                    <option value="false">No</option>
                </select>
                <label>Add Charge</label>
            </div>
        </div>

        <div class="col s10">

            <div v-for="index in 56" :key="index" style="float: left;">
                <img v-bind:src="'./shield.php?'
             + 'refresh=' + shield.refresh
             + '&id=' + (seeded ? index : Math.floor(Math.random() * 1000000) )
             + '&foreground=' + shield.foreground
             + '&background=' + shield.background
             + '&fieldType=' + shield.fieldType
             + '&ordinary=' + shield.ordinary
             + '&party=' + shield.party
             + '&addCharge=' + shield.addCharge
            " width="128" height="128"/>
            </div>
        </div>
    </div>

</div>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            shield: {
                refresh: 1,
                foreground: '',
                background: '',
                fieldType: '',
                ordinary: '',
                party: '',
                addCharge: '',
            },
            seeded: 0,
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>


</body>
</html>
