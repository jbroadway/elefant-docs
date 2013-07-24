# Comparison to Sitellite: Templates

Back to [[Comparison to Sitellite CMS]].

***

Sitellite has two template languages: the XML-based XT for design templates (called layouts in Elefant), and SimpleTemplate (`.spt` files) for more concise templates used by boxes.

Elefant has one very simple but flexible template engine for both designer layouts and app developers. It looks closer to SimpleTemplate than XT, but was inspired more by other template engines such as Django's, with several twists of its own. It caches templates to PHP files before running them, so it's also very fast.

Elefant layouts live in the `layouts` folder (`inc/html` in Sitellite), and app templates live in the app's `views` folder (`inc/app/myapp/html` in Sitellite).

For more info, see [[Templates]].

Calling a SimpleTemplate in Sitellite:

	<?php
	
	echo template_simple ('file.spt', $params);
	
	?>

Calling a template in Elefant:

	<?php
	
	echo $tpl->render ('myapp/template', $params);
	
	?>

This would call the template `apps/myapp/views/template.html`.