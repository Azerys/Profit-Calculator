var xhr = new XMLHttpRequest();

window.onload = function() {
    xhr.open("GET", "https://api.guildwars2.com/v2/commerce/prices?ids=19699,19700,19702,19722,19726,19727,19724,19748,19739,19741,19743,46738,46736,46741,19721", true);

    xhr.onreadystatechange = function() {
        
        if (xhr.readyState == 4) {
       
            if(xhr.status == 200) {
                var mainApiArray = JSON.parse(xhr.responseText);
                
                //An object containing names for materials, used as keys in the main API object "info"
                var materialNames = {
                    19699 : "iron",
                    19700 : "mith",
                    19702 : "plat",
                    19722 : "elder",
                    19726 : "soft",
                    19727 : "seasoned",
                    19724 : "hard",
                    19748 : "silk",
                    19739 : "wool",
                    19741 : "cotton",
                    19743 : "linen",
                    46738 : "delIngot",
                    46736 : "spiritPlank",
                    46741 : "boltDamask",
                    19721 : "ecto"
                };
                
                //Getting the HTTP request method
                var requestMethod;
                
                requestMethod = document.getElementById("request-method").content;
                
                console.log(requestMethod);
                
                //Variables for the for-in loop that creates the main API object "info"
                var info = {};
                var item;
                var key;
                
                //Creates an object named "info" that contains the main API information.  Each material is returned by the API as an object
                //Each material object is paired with a string key (the abreviated name of the material) that represents it
                for (item in mainApiArray) {
                    key = materialNames[mainApiArray[item]['id']];
                    info[key] = mainApiArray[item];
                }
                
                
                //Variables for each material that hold the properties of the objects 
                var infoIron = info['iron'];          //Creates the object for iron from the main API object "info"
                var buysIron = infoIron['buys'];      //Stores the highest buying price of iron
                var sellsIron = infoIron['sells'];    //Stores the lowest selling price of iron
                
                var infoMith = info['mith'];
                var buysMith = infoMith['buys'];
                var sellsMith = infoMith['sells'];
                
                var infoPlat = info['plat'];
                var buysPlat = infoPlat['buys'];
                var sellsPlat = infoPlat['sells'];
                
                var infoElder = info['elder'];
                var buysElder = infoElder['buys'];
                var sellsElder = infoElder['sells'];
                
                var infoSoft = info['soft'];
                var buysSoft = infoSoft['buys'];
                var sellsSoft = infoSoft['sells'];
                
                var infoSeasoned = info['seasoned'];
                var buysSeasoned = infoSeasoned['buys'];
                var sellsSeasoned = infoSeasoned['sells'];
                
                var infoHard = info['hard'];
                var buysHard = infoHard['buys'];
                var sellsHard = infoHard['sells'];
                
                var infoSilk = info['silk'];
                var buysSilk = infoSilk['buys'];
                var sellsSilk = infoSilk['sells'];
                
                var infoWool = info['wool'];
                var buysWool = infoWool['buys'];
                var sellsWool = infoWool['sells'];
                
                var infoCotton = info['cotton'];
                var buysCotton = infoCotton['buys'];
                var sellsCotton = infoCotton['sells'];
                
                var infoLinen = info['linen'];
                var buysLinen = infoLinen['buys'];
                var sellsLinen = infoLinen['sells'];
                
                var infoDelIngot = info['delIngot'];
                var buysDelIngot = infoDelIngot['buys'];
                var sellsDelIngot = infoDelIngot['sells'];
                
                var infoSpiritPlank = info['spiritPlank'];
                var buysSpiritPlank = infoSpiritPlank['buys'];
                var sellsSpiritPlank = infoSpiritPlank['sells'];
                
                var infoBoltDamask = info['boltDamask'];
                var buysBoltDamask = infoBoltDamask['buys'];
                var sellsBoltDamask = infoBoltDamask['sells'];
                
                var infoEcto = info['ecto'];
                var buysEcto = infoEcto['buys'];
                var sellsEcto = infoEcto['sells'];
                
                var intToCoinArray = function(price) {
                    var priceG = Math.trunc(price / 10000);
                    price -= priceG * 10000;
                    var priceS = Math.trunc(price / 100);
                    price -= priceS * 100;
                    var priceC = price;
                    var priceUnconverted = [priceG, priceS, priceC];
                    return priceUnconverted;    
                };
                
                // Any Better?
                //Ah, yes
                var lowestSellPriceData = {
                    'mith'        : intToCoinArray(buysMith['unit_price']),
                    'iron'        : intToCoinArray(buysIron['unit_price']),
                    'plat'        : intToCoinArray(buysPlat['unit_price']),
                    'elder'       : intToCoinArray(buysElder['unit_price']),
                    'soft'        : intToCoinArray(buysSoft['unit_price']),
                    'seasoned'    : intToCoinArray(buysSeasoned['unit_price']),
                    'hard'        : intToCoinArray(buysHard['unit_price']),
                    'silk'        : intToCoinArray(buysSilk['unit_price']),
                    'wool'        : intToCoinArray(buysWool['unit_price']),
                    'cotton'      : intToCoinArray(buysCotton['unit_price']),
                    'linen'       : intToCoinArray(buysLinen['unit_price']),
                    'delIngot'    : intToCoinArray(sellsDelIngot['unit_price']),
                    'spiritPlank' : intToCoinArray(sellsSpiritPlank['unit_price']),
                    'boltDamask'  : intToCoinArray(sellsBoltDamask['unit_price']),
                    'ecto'        : intToCoinArray(buysEcto['unit_price'])
                };
                
                
                console.log(lowestSellPriceData['iron']);
                
                
                // Can you see this?
                //yeah
                var material;
                var priceArray;
                
                //if(requestMethod == "GET")    
                //{
                    for (material in lowestSellPriceData) 
                    {
                        priceArray = lowestSellPriceData[material];
                        
                        document.getElementById(material+"G").value = priceArray[0];
                        document.getElementById(material+"S").value = priceArray[1];
                        document.getElementById(material+"C").value = priceArray[2];
                    }
                //}
            }
            else {
                alert("Received non 200 status code: " + xhr.statusText);
            }
        } else {
            console.log("readyState: " + xhr.readyState);
        }
    };
    
    xhr.send();

};