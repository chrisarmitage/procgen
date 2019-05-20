<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

</head>
<body>
<div id="app">
    <button v-on:click="shield.refresh += 1">Refresh</button>
    <select v-model="shield.foreground">
        <option value="">Random</option>
        <option disabled >Metals</option>
        <option value="ffdc0a">Gold</option>
        <option value="f0f0f0">Silver</option>
        <option disabled >Colours</option>
        <option value="0000ff">Blue</option>
        <option value="ff0000">Red</option>
        <option value="aa00aa">Purple</option>
        <option value="000000">Black</option>
        <option value="009600">Green</option>
    </select>
    <select v-model="shield.background">
        <option value="">Random</option>
        <option disabled >Metals</option>
        <option value="ffdc0a">Gold</option>
        <option value="f0f0f0">Silver</option>
        <option disabled >Colours</option>
        <option value="0000ff">Blue</option>
        <option value="ff0000">Red</option>
        <option value="aa00aa">Purple</option>
        <option value="000000">Black</option>
        <option value="009600">Green</option>
    </select>
    <select v-model="shield.fieldType">
        <option value="">Random</option>
        <option value="ordinary">Ordinary</option>
        <option value="party">Party</option>
        <option value="blank">Blank</option>
    </select>
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
    <select v-model="shield.addCharge">
        <option disabled >Add Charge</option>
        <option value="">Random</option>
        <option value="true">Yes</option>
        <option value="false">No</option>
    </select>

    <div style="clear: both;"></div>

        <img v-bind:src="'./shield.php?'
             + 'refresh=' + shield.refresh
             + '&id=0'
             + '&foreground=' + shield.foreground
             + '&background=' + shield.background
             + '&fieldType=' + shield.fieldType
             + '&ordinary=' + shield.ordinary
             + '&party=' + shield.party
             + '&addCharge=' + shield.addCharge
            " width="512" height="512" />
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
        }
    })
</script>

</body>
</html>