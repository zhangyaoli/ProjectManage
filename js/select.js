<!--
function moveLeft() {
            var lBox = document.getElementById("leftBox");
            var rBox = document.getElementById("rightBox");
            var count = 0;;
            for (var i = 0, len = lBox.length; i < len; i++) { //>
                if (lBox[i].selected) {
                    rBox.options.add(new Option(lBox.options[i].text, lBox[i].value));
                    count++;
                }
            }
            for (var i = 0; i < count; i++) {   //>
                lBox.remove(lBox.selectedIndex);
            }
        }
        function moveRight() {
            var lBox = document.getElementById("leftBox");
            var rBox = document.getElementById("rightBox");
            var count = 0;;
            for (var i = 0, len = rBox.length; i < len; i++) {//>
                if (rBox[i].selected) {
                    lBox.options.add(new Option(rBox.options[i].text, rBox[i].value));
                    count++;
                }
            }
            for (var i = 0; i < count; i++) {   //>
                rBox.remove(rBox.selectedIndex);
            }
        }
        function selectAll(){
        	var rBox = document.getElementById("rightBox");
        	for (var i = 0, len = rBox.length; i < len; i++) {//>
                rBox.options[i].selected=true;
                }
        }
		-->