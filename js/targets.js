/**
 * Show/hide targets.
 */
var targets = (function ($) {
	var self = {};
	
	self.opts = {};
	
	self.make_id = function (label) {
		return label.trim ().toLowerCase ().replace (/[^a-z0-9-]+/gi, '-');
	};
	
	self.init = function (opts) {
		var defaults = {
				targets: {},
				select: '#targets',
				cookie_prefix: 'elefant_doctarget_'
			},
			select = '';
		
		self.opts = $.extend (defaults, opts);
		
		for (var label in self.opts.targets) {
			var lower = self.make_id (label),
				selected = $.cookie (self.opts.cookie_prefix + lower);

			select = '<p><span id="target-select-label-' + lower + '" class="target-select-label">' + label + ':</span> '
				+ '<select id="target-select-' + lower + '" class="target-select" data-label="' + lower + '">';

			for (var i in self.opts.targets[label]) {
				var target = self.make_id (self.opts.targets[label][i]);
				select += '<option value="' + target + '">' + self.opts.targets[label][i] + '</option>';
			}

			select += '</select></p>';

			$(self.opts.select).append (select);

			if (selected === null) {
				$('.target-' + lower).hide ().first ().show ();
			} else {
				$('.target-' + lower).hide ().filter ('#target-' + lower + '-' + selected).show ();
				$('#target-select-' + lower).val (selected);
			}
		}

		$('.target-select').on ('change', function (e) {
			var label = $(this).data ('label'),
				value = $(this).val ();

			$.cookie (self.opts.cookie_prefix + label, value, { expires: 90, path: '/' });

			$('.target-' + label).fadeOut ('fast', function () {
				$('#target-' + label + '-' + value).fadeIn ('fast');
			});
		});
	};
	
	return self;
})(jQuery);