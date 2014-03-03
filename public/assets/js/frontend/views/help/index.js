Chawnow.Views.Helppage = Backbone.View.extend({
	el: ".viewport",

	events: {
		'click .question': 'toggleAnswer'
	},

	initialize: function() {
		console.log('Starting view');
	},

	toggleAnswer: function (event) {

		var el = $(event.currentTarget);
		var answer = el.next();
			answer.slideToggle();
			
	}
});