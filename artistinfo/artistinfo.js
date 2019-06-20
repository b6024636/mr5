'use strict';

angular.module('myApp.artistinfo', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/artistinfo', {
    templateUrl: 'artistinfo/artistinfo.html',
    controller: 'ArtistInfoCtrl'
  });
}])

.controller('ArtistInfoCtrl', ['$scope', function($scope) {


  $scope.artists = {
      'bolero' : {
          'name': 'bolero',
          'img': 'bolero.jpg',
          'description': 'Hi I\'m dan :)'
      },
      'tamot' : {
          'name': 'tamot',
          'img': 'tamot.jpg',
          'description': 'Hi I\'m graham :)'
      },
      'rekrow' : {
          'name': 'rekrow',
          'img': 'rekrow.jpg',
          'description': 'Hi I\'m richie :)'
      },
      'andyroid':{
          'name': 'andyroid',
          'img': 'andyroid.jpg',
          'desciption': 'Hi I\'m ben :)'
      }
  };

  $scope.lads = Object.keys($scope.artists).map(function(key){
     return [key, $scope.artists[key]];
  });

  $scope.artistModal = function(artist)
  {
      let elem = angular.element(document.querySelector('body')),
        modal = angular.element(document.querySelector('#modal-' + artist));

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
        '            $(\'.modal\').remove();\n' +
        '        });\n' +
        '       $("a").on("click", function(){\n' +
        '           $(".modal").remove();' +
        '       });' +
        '       $("button").on("click", function(){\n' +
        '           $(".modal").remove();' +
        '       });' +
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