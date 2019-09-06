'use strict';

angular.module('myApp.tickets', ['ngRoute'])

    .config(['$routeProvider', function($routeProvider) {
        $routeProvider.when('/tickets', {
            templateUrl: 'tickets/tickets.html',
            controller: 'TicketsCtrl'
        });
    }])

    .controller('TicketsCtrl', ['$scope', '$http', function($scope, $http) {

        $scope.lads = "";
        $http.get('http://inspectionssdev.kinspeed.com/app/lib/constants/artists.json')
            .then(
                function(response){
                    $scope.artists = response.data;
                    $scope.lads = Object.keys($scope.artists).map(function(key){
                        return [key, $scope.artists[key]];
                    });
                },
                function(error){
                    console.log(error);
                });


        $scope.artistModal = function(artist)
        {
            let elem = angular.element(document.querySelector('body')),
                modal = angular.element(document.querySelector('#modal-' + artist));

            // var modalPop = Popeye.openModal({
            //     template: $scope.modalTemplate(artist),
            //     controller: "TicketsCtrl as ctrl"
            //
            // });


            if(modal.length < 1)
                elem.append($scope.modalTemplate(artist));
        };


        $scope.modalTemplate = function(artist)
        {
            $scope.html = '' +
                '<div class="modal display-block bg-white" id="modal-'+artist+'">' +
                '   <div class="modal-body">' +
                '       <div class="modal-heading">' +
                '           <h3 class="font-weight-bold">'+artist[0].toUpperCase() + artist.substr(1).toLowerCase()+'</h3>' +
                '           <div class="close">x</div>' +
                '       </div>' +
                '       <div class="modal-description">' +
                '           <div class="modal-image">' +
                '               <img src="'+$scope.getArtistImage(artist)+'"/>' +
                '           </div>' +
                '           <div class="modal-text">' +
                '               <span>'+$scope.getArtistDescription(artist)+'</span>' +
                '           </div>' +
                '       </div>' +
                '   </div>'  +
                '    <script>\n' +
                '        $(\'.modal\').find(\'.close:first\').on(\'click\', function(){\n' +
                '            removeModal();\n' +
                '        });\n' +
                '       $("a").on("click", function(){\n' +
                '           removeModal();' +
                '       });' +
                '       $("button").on("click", function(){\n' +
                '           removeModal();' +
                '       });' +
                '       setTimeout(function(){' +
                '           var left = "10%";' +
                '           if($(window).width() < 500)' +
                '               left = "8%";' +
                '           $(".modal").css("left", left);' +
                '       }, 10);' +
                '       $(".modal-image").on("swipeleft", function(){' +
                '           if($(window).width() < 500){' +
                '               removeModal();'+
                '           }' +
                '       });' +
                '       function removeModal(){' +
                '           $(".modal").css("left", "-100%");' +
                '           setTimeout(function(){' +
                '               $(".modal").remove();' +
                '           }, 300);' +
                '       };' +
                '    </script>'+
                '</div>\n';

            return $scope.html;
        };

        $scope.getArtistDescription = function(artist)
        {
            return $scope.artists[artist].description;
        };

        $scope.getArtistImage = function(artist)
        {
            return '/app/media/img/artist-pics/'+$scope.artists[artist].img;
        };

    }]);