require.config({
	paths: {
		'text': '/assets/js/libs/text'
	}
});

require(['views/app'], function (AppView) {
	var view = new AppView;
});