'use strict';

describe('myApp.tickets module', function() {

  beforeEach(module('myApp.tickets'));

  describe('tickets controller', function(){

    it('should ....', inject(function($controller) {
      //spec body
      var ticketsCtrl = $controller('View1Ctrl');
      expect(ticketsCtrl).toBeDefined();
    }));

  });
});