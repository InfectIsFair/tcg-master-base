{% extends 'template.html' %}

{% block title %} - View Card{% endblock %}


{% block main %}
<main>
    <section class="card-main">
        <!-- card details -->
        <div class="card-main__div">
            <!-- card name -->
            <h1 class="bottom--60">{{ value[2] }}</h1>
            <!-- card details -->
            <div class="card-details-div">
                <!-- set & rarity -->
                <div class="card-col-div">
                    <label for="set">Card set</label>
                    <p style="padding-bottom: 25px;" id="set">{{ value[4] }}</p>
                    <label style="padding-top: 25px;" for="rarity">Rarity</label>
                    <p id="rarity">{{ value[3] }}</p>
                </div>
                <!-- setnum & price -->
                <div class="card-col-div">
                    <label for="setnum">Set number</label>
                    <p style="padding-bottom: 25px;" id="setnum">{{ value[5] }}</p>
                    <label style="padding-top: 25px;" for="price">Price</label>
                    <p id="price">{{ value[6] }}</p>
                </div>
            </div>
            <!-- card text -->
            <p class="top--50 card-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Eaque non illum commodi harum, iste laudantium, dolore accusamus nesciunt cum debitis voluptates dolores ratione facere est! Vitae amet aliquam neque praesentium.</p>
        </div>
        <!-- card image -->
        <div class="card-img-div">
            <img alt="Image of {{ value[2] }}" class="card-img-div__child" src="{{url_for('static', filename='tcg-master-base_' + value[0] + '.jpeg')}}">
        </div>
        <!-- interactivity -->
        <div class="card-main__div">
            <h3>Other printings / variations of this card:</h3>
            <ul>
                <li><a href="#">Lorem</a></li>
                <li><a href="#">Ipsum</a></li>
                <li><a href="#">Dolor</a></li>
                <li><a href="#">Sit</a></li>
                <li><a href="#">Amet</a></li>
                <li><a href="#">Consectetur</a></li>
                <li><a href="#"><?= "HI"; ?></a></li>
                <?php

                $cardName = {{ value[2] }};
                $cards = {{ cards }};
                foreach ($cards as $value) {
                    if ($value[2] === $cardName) {
                        echo "<li><a href='#'>{$value} | {$value[4]} | {$value[6]}</a></li>";
                    }
                }
                ?>
            </ul>
            <div class="card-buttons">
                <div class="card-buttons__div">
                    <button onclick="lastCardView(false)">Previous card</button>
                    <button onclick="nextCardView(false)">Next card</button>
                </div>
                <p class="spacer"></p>
                <div class="card-buttons__div">
                    <button onclick="lastCardView(true)">Previous set</button>
                    <button onclick="nextCardView(true)">Next set</button>
                </div>
            </div>
        </div>
    </section>
</main>
{% endblock %}

{% block footer %}
<div id="snackbar">
    Our database doesn't go any further.
</div>

<script>
    function nextCardView(wantError) {
        setCSV = {{ setCSV|tojson }};
        if (wantError) {
            setUp();
        } else {
            let dnsExtension = "/magic-card-database/M";
            let set = '{{ value[4] }}';
            let num = '{{ value[5] }}';
            num = Number(num);

            let maxSetNum;
            for (let i=0; i < setCSV.length; i++) {
                if (set === setCSV[i][1]) {
                    maxSetNum = setCSV[i][3];
                }
            }

            if (String(num) === String(maxSetNum)) {
                try {
                    causeAnError();
                } catch {
                    setUp();
                }
            } else {
                num++;
                dnsExtension = dnsExtension.concat(set.toLowerCase());
                dnsExtension = dnsExtension.concat(String(num));
                window.location.href = dnsExtension;
            }
        }
    }

    function lastCardView(wantError) {
        if (wantError) {
            setDown();
        } else {
            let dnsExtension = "/magic-card-database/M";
            let set = '{{ value[4] }}';
            let num = '{{ value[5] }}';
            num = Number(num);
            num--;
            if (num === 0) {
                try {
                    causeAnError();
                } catch {
                    setDown();
                }
            } else {
                dnsExtension = dnsExtension.concat(set.toLowerCase());
                dnsExtension = dnsExtension.concat(String(num));
                window.location.href = dnsExtension;
            }
        }
    }

    function setUp() {
        console.log("Hello world!");
        setCSV = {{ setCSV|tojson }};
        let curSetU = {{ value[4]|tojson }};
        let newSetUp;
        let setCheckUp = false;

        for (let i=0; i < setCSV.length; i++) {
            if (curSetU === setCSV[i][1]) {
                try {
                    newSetUp = setCSV[i+1][1];
                    newSetUp = newSetUp;
                } catch {
                    setCheckUp = true;
                    let toast = document.getElementById("snackbar");
                    toast.className = "show";
                    setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);
                }
            }
        }

        if (setCheckUp == false) {
            dnsExtension = "/magic-card-database/";
            dnsExtension = dnsExtension.concat("M" + newSetUp.toLowerCase() + "1/");
            window.location.href = dnsExtension;
        }
    }

    function setDown() {
        console.log("Hello world!");
        setCSV = {{ setCSV|tojson }};
        let curSetD = {{ value[4]|tojson }};
        let newSetNum;
        let newSetDown;
        let setCheckDown = false;

        for (let i=0; i < setCSV.length; i++) {
            if (curSetD === setCSV[i][1]) {
                try {
                    newSetNum = setCSV[i-1][3];
                    newSetDown = setCSV[i-1][1];
                    newSetDown = newSetDown;
                } catch {
                    setCheckDown = true;
                    let toast = document.getElementById("snackbar");
                    toast.className = "show";
                    setTimeout(function(){ toast.className = toast.className.replace("show", ""); }, 3000);
                }
            }
        }
        if (setCheckDown == false) {
            dnsExtension = "/magic-card-database/";
            dnsExtension = dnsExtension.concat("M" + newSetDown.toLowerCase() + newSetNum + "/");
            window.location.href = dnsExtension;
        }
    }
</script>
{% endblock %}