



// Ajax Requests

$.ajaxSetup({

    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#searchByProperty").click(function(e){
    e.preventDefault();
    ipage =1;
    $('.swiper-wrapper').empty();
    const address = $("#search").val();
    codeAddress(address);
});


$('#searchByAddress').click(function (e) {
    e.preventDefault();
    const address = $("#searchAddress").val();
    $.ajax({
        type:'post',
        url:'/getPropertyResponse',
        data:{address:address},
        success:function(data){
            console.log(data);
            $('#LegalAddress').text(data);
        },
        timeout: 5000
    });
})

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }
    }
}


function getlist(lat,lng)
 {
     var totalPages;
     $.ajax({
         type:'get',
         url:'/getTotalPages',
         data:{lat:lat,lng:lng,zip:postalcode},
         success:function(data){
             totalPages = data;
             console.log(data);

         },
         complete:function()
         {
             for (let i = 1; i <= totalPages; i++) {
                 console.log(postData('/allpropertiesList', {lat: lat, lng: lng, page: i, zip: postalcode}));
             }
             //getpageData(lat,lng,totalPages);

                /* for (let i = 1; i <= totalPages; i++) {

                     $.ajax({
                         type: 'get',
                         url: '/allpropertiesList',
                         async:false,
                         data: {lat: lat, lng: lng, page: i},
                         success: function (data) {
                             for (const property of data.property) {
                                 var text = '<div class="list-group-item list-group-item-action card"><div class="card-body"><h5 class="card-title">'+property['address']['oneLine']+'</h5><h6 class="card-subtitle mb-2 text-muted">'+property['summary']['legal1']+'</h6></div></div>';
                                 $("#listpro").append(text);
                             }
                             //console.log(data);

                         },
                         timeout: 5000
                     });
             }*/
         },
         timeout: 5000
     });
}
function buildUrl(url, parameters) {
    let qs = "";
    for (const key in parameters) {
        if (parameters.hasOwnProperty(key)) {
            const value = parameters[key];
            qs +=
                encodeURIComponent(key) + "=" + encodeURIComponent(value) + "&";
        }
    }
    if (qs.length > 0) {
        qs = qs.substring(0, qs.length - 1); //chop off last "&"
        url = url + "?" + qs;
    }

    return url;
}
function postData(url = ``, data = {}) {
    // Default options are marked with *
     fetch(buildUrl(url,data), {
        method: "get", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, cors, *same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // "Content-Type": "application/x-www-form-urlencoded",
        },
        redirect: "follow", // manual, *follow, error
        referrer: "no-referrer", // no-referrer, *client
    })
         .then(function(response) {
             if (response.status >= 200 && response.status < 300) {
                 return response.json()
             }
             throw new Error(response.statusText)
         })
         .then(function(data) {
             console.log(data);
             if(data) {
                 for (const property of data.property) {
                     const pattern = /l.([0-9]*)-([0-9]*)/gi;
                     const patt1 = /lot.([0-9]*)&([0-9]*)/gi;
                     if(property['summary']['legal1']) {
                         var result = property['summary']['legal1'].match(pattern);
                         var result2 = property['summary']['legal1'].match(patt1);
                         if (result) {
                             var text = '<div class="swiper-slide">'+
                                 '<div class="box selectPOI" id="5">'+
                                 '<h1>' + property['address']['oneLine'] + '</h1>'+
                                 '<div class="restaurant-content">'+
                                 '<label>Legal Description</label>'+
                                 '<small>' + property['summary']['legal1'] + '</small></div></div></div>';
                             $(".swiper-wrapper").append(text);
                         }
                         else if (result2)
                         {
                             var text = '<div class="swiper-slide">'+
                                 '<div class="box selectPOI" id="5">'+
                                 '<h1>' + property['address']['oneLine'] + '</h1>'+
                                 '<div class="restaurant-content">'+
                                 '<label>Legal Description</label>'+
                                 '<small>' + property['summary']['legal1'] + '</small></div></div></div>';
                             $(".swiper-wrapper").append(text);
                         }
                     }
                 }
             }
             f();
         })
}
     var ipage =1;
     function getpageData(lat,lng,totalpage) {
         console.log(postalcode);
         $.ajax({
             type: 'get',
             async:false,
             url: '/allpropertiesList',
             data: {lat: lat, lng: lng, page: ipage,zip:postalcode},
             success: function (data) {
                 if(data) {
                     for (const property of data.property) {
                         const pattern = /l.([0-9]*)-([0-9]*)/gi;
                         const patt1 = /lot.([0-9]*)&([0-9]*)/gi;
                         if(property['summary']['legal1']) {
                             var result = property['summary']['legal1'].match(pattern);
                             var result2 = property['summary']['legal1'].match(patt1);
                             if (result) {
                                 var text = '<div class="swiper-slide">'+
                                     '<div class="box selectPOI" id="5">'+
                                     '<h1>' + property['address']['oneLine'] + '</h1>'+
                                     '<div class="restaurant-content">'+
                                     '<label>Legal Description</label>'+
                                     '<small>' + property['summary']['legal1'] + '</small></div></div></div>';
                                 $(".swiper-wrapper").append(text);
                             }
                             else if (result2)
                             {
                                 var text = '<div class="swiper-slide">'+
                                     '<div class="box selectPOI" id="5">'+
                                     '<h1>' + property['address']['oneLine'] + '</h1>'+
                                     '<div class="restaurant-content">'+
                                     '<label>Legal Description</label>'+
                                     '<small>' + property['summary']['legal1'] + '</small></div></div></div>';
                                 $(".swiper-wrapper").append(text);
                             }
                         }
                     }
                 }
                 //console.log(data);

             },
             complete:function()
             {
                 ipage++;
                 if(ipage <=totalpage)
                 {
                     getpageData(lat,lng,totalpage)
                 }
             },
             timeout: 5000
         });

     }



function f() {
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 5,
        direction: 'vertical',
        slideToClickedSlide: false,
        on:{
            click: function(){
                //openInfoModal(this.clickedIndex+1);
            },
        },
        navigation: {
            nextEl: '.prev-slide',
            prevEl: '.next-slide',
        }
    });
}





















// Auto complete text field for google map
var lat,lng,postalcode;
var placeSearch, autocomplete;
var componentForm = {
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('search')),
        {types: ['geocode']});
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('searchAddress')),
        {types: ['geocode']});

    //autocomplete.addListener('place_changed', fillInAddress);

}
// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}

var geocoder;

function codeAddress(address) {

    geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'address': address
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            //alert(results[0].geometry.location);
            for(let a of results[0].address_components)
            {
                if(a.types[0] == 'postal_code')
                {
                    postalcode = parseInt(a.long_name)
                    console.log(parseInt(postalcode));
                }

            }
            lat = results[0].geometry.location.lat();
            lng = results[0].geometry.location.lng()
            $.ajax({
                type:'POST',
                url:'/getzipdata',
                data:{address:address,location : [results[0].geometry.location.lat(),results[0].geometry.location.lng()],zip:postalcode},
                success:function(data){
                    //console.log(data);
                    polys = [data];
                    init();
                },
                complete:function(){
                    getlist(lat,lng)
                },
                timeout: 5000
            });
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}





















//  Zip code Area highlight
var polys;
function parsePolyStrings(ps) {
    var i, j, lat, lng, tmp, tmpArr,
        arr = [],
        //match '(' and ')' plus contents between them which contain anything other than '(' or ')'
        m = ps.match(/\([^\(\)]+\)/g);
    if (m !== null) {
        for (i = 0; i < m.length; i++) {
            //match all numeric strings
            tmp = m[i].match(/-?\d+\.?\d*/g);
            if (tmp !== null) {
                //convert all the coordinate sets in tmp from strings to Numbers and convert to LatLng objects
                for (j = 0, tmpArr = []; j < tmp.length; j+=2) {
                    lng = Number(tmp[j]);
                    lat = Number(tmp[j + 1]);
                    tmpArr.push(new google.maps.LatLng(lat, lng));
                }
                arr.push(tmpArr);
            }
        }
    }
    //array of arrays of LatLng objects, or empty array
    return arr;
}

function init() {
    var i, tmp,
        myOptions = {
            zoom: 13,
            center: new google.maps.LatLng(lat, lng)
        },
        map = new google.maps.Map(document.getElementById("map"), myOptions);

    var marker;
    //console.log(locations);

    marker = new google.maps.Marker({
        position: new google.maps.LatLng(lat, lng),
        map: map,
        animation: google.maps.Animation.DROP
    });

    for (i = 0; i < polys.length; i++) {
        tmp = parsePolyStrings(polys[i]);
        if (tmp.length) {
            polys[i] = new google.maps.Polygon({
                paths : tmp,
                strokeColor : '#0051FF',
                strokeOpacity : 0.8,
                strokeWeight : 2,
                fillColor : '#0051FF',
                fillOpacity : 0.20
            });
            polys[i].setMap(map);
        }
    }
    $('#map').css('height','450px');
}


