<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

</head>
<body>
<div id="app">
    <select v-model="shield.fieldType">
        <option value="">Random</option>
        <option value="ordinary">Ordinary</option>
        <option value="party">Party</option>
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

    <div style="clear: both;"></div>

    <div v-for="index in 50" :key="index" style="float: left;">
        <img v-bind:src="'./shield.php?id=' + index + '&fieldType=' + shield.fieldType + '&ordinary=' + shield.ordinary + '&party=' + shield.party" />
    </div>
</div>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            shield: {
                fieldType: 'party',
                ordinary: '',
                party: 'gyronny',
            }
        }
    })
</script>

</body>
</html>
