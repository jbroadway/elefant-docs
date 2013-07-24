# Elefant with Backbone.js

In this tutorial, we're going to take the [Todos](https://github.com/documentcloud/backbone/tree/master/examples/todos)
app from the [Backbone.js](http://documentcloud.github.com/backbone/) examples
and adapt it to communicate with Elefant for storage.

## Step 1. Create a new app

To create a new Elefant app on an existing installation, enter the following
on the command line:

	$ cd /path/to/site
	$ ./conf/elefant build-app todos

This will create a new app under `apps/todos` with the standard folder structure
for an app.

> Note: You can view and download the complete source code for this app [here](http://github.com/jbroadway/todos).

## Step 2. Add the Backbone.js files

In your newly-created app, create a new folder `apps/todos/js` to contain the Javascript
files, and an `apps/todos/css` folder for the CSS files.

You can download the necessary Javascript files, and a `destroy.png` image we'll be using,
from these links:

* [Backbone.js](http://documentcloud.github.com/backbone/backbone-min.js)
* [Underscore.js](https://raw.github.com/documentcloud/underscore/master/underscore-min.js)
* [destroy.png](https://github.com/documentcloud/backbone/raw/master/examples/todos/destroy.png) (save to `apps/todos/css/`)

> Note: jQuery is built into Elefant already when you've included the `{! admin/head !}` tag in your templates, so we'll assume we can leave it out here.

## Step 3. Edit the handler

Open the file `apps/todos/handlers/index.php` and change it to the following:

	<?php
	
	$page->title = 'Todos';
	$page->add_script ('/apps/todos/js/underscore-1.1.6.js');
	$page->add_script ('/apps/todos/js/backbone-min.js');
	$page->add_script ('/apps/todos/js/todos.js');
	$page->add_script ('/apps/todos/css/todos.css');
	echo $tpl->render ('todos/index');
	
	?>

Don't worry about the `todos.js` and `todos.css` files just yet. We'll add those
in a later step.

## Step 4. Create the view

Open the file `apps/todos/views/index.html` and change it to the following:

	<!-- App Interface -->
	
	<div id=""todoapp"">
	  <div class=""content"">
		<div id=""create-todo"">
		  <input id=""new-todo"" placeholder=""What needs to be done?"" type=""text"" />
		  <span class=""ui-tooltip-top"" style=""display:none;"">Press Enter to save this task</span>
		</div>
	
		<div id=""todos"">
		  <ul id=""todo-list""></ul>
		</div>
	
		<div id=""todo-stats""></div>
	  </div>
	</div>
	
	<ul id=""instructions"">
	  <li><strong>Instructions:</strong> Double-click to edit a todo.</li>
	</ul>
	
	<div id=""credits"">
	  Created by <a href=""http://jgn.me/"">J&eacute;r&ocirc;me Gravel-Niquet</a>
	</div>
	
	<!-- Templates -->
	
	<script type=""text/template"" id=""item-template"">
	  <div class=""todo <%= done ? 'done' : '' %>"">
		<div class=""display"">
		  <input class=""check"" type=""checkbox"" <%= done ? 'checked=""checked""' : '' %> />
		  <div class=""todo-text""></div>
		  <span class=""todo-destroy""></span>
		</div>
		<div class=""edit"">
		  <input class=""todo-input"" type=""text"" value="""" />
		</div>
	  </div>
	</script>
	
	<script type=""text/template"" id=""stats-template"">
	  <% if (total) { %>
		<span class=""todo-count"">
		  <span class=""number""><%= remaining %></span>
		  <span class=""word""><%= remaining == 1 ? 'item' : 'items' %></span> left.
		</span>
	  <% } %>
	  <% if (done) { %>
		<span class=""todo-clear"">
		  <a href=""#"">
			Clear <span class=""number-done""><%= done %></span>
			completed <span class=""word-done""><%= done == 1 ? 'item' : 'items' %></span>
		  </a>
		</span>
	  <% } %>
	</script>

The view includes two sections: the app interface, and two templates for displaying
todo items and todo stats (total items, remaining items, etc.).

## Step 5. Add the CSS

Here is the CSS for the todos. Save it to `apps/todos/css/todos.css`.

	#create-todo {
	  position: relative;
	}
	  #create-todo input {
		width: 327px;
		font-size: 18px;
		font-family: inherit;
		line-height: 1.2em;
		border: 0;
		outline: none;
		padding: 3px;
		border: 1px solid #999999;
		-moz-box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		-webkit-box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		-o-box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
	  }
		#create-todo input::-webkit-input-placeholder {
		  font-style: italic;
		}
	  #create-todo span {
		position: absolute;
		z-index: 999;
		width: 170px;
		left: 50%;
		margin-left: -85px;
	  }
	
	#todo-list {
	  margin-top: 10px;
	  list-style-type: none;
	  margin-left: 0px;
	}
	  #todo-list li {
		padding: 12px 20px 11px 0;
		position: relative;
		font-size: 24px;
		line-height: 1.1em;
		border-bottom: 1px solid #cccccc;
		list-style-type: none;
		margin-left: 0px;
	  }
		#todo-list li:after {
		  content: ""0"";
		  display: block;
		  height: 0;
		  clear: both;
		  overflow: hidden;
		  visibility: hidden;
		}
		#todo-list li.editing {
		  padding: 0;
		  border-bottom: 0;
		}
	  #todo-list .editing .display,
	  #todo-list .edit {
		display: none;
	  }
		#todo-list .editing .edit {
		  display: block;
		}
		#todo-list .editing input {
		  width: 300px;
		  font-size: 18px;
		  font-family: inherit;
		  margin: 0;
		  line-height: 1.2em;
		  border: 0;
		  outline: none;
		  padding: 10px 7px 0px 27px;
		  border: 1px solid #999999;
		  -moz-box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		  -webkit-box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		  -o-box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		  box-shadow: rgba(0, 0, 0, 0.2) 0 1px 2px 0 inset;
		}
	  #todo-list .check {
		position: relative;
		top: 9px;
		margin: 0 10px 0 7px;
		float: left;
	  }
	  #todo-list .done .todo-text {
		text-decoration: line-through;
		color: #777777;
	  }
	  #todo-list .todo-destroy {
		position: absolute;
		right: 5px;
		top: 14px;
		display: none;
		cursor: pointer;
		width: 20px;
		height: 20px;
		background: url(destroy.png) no-repeat 0 0;
	  }
		#todo-list li:hover .todo-destroy {
		  display: block;
		}
		#todo-list .todo-destroy:hover {
		  background-position: 0 -20px;
		}
	
	#todo-stats {
	  *zoom: 1;
	  margin-top: 10px;
	  color: #777777;
	}
	  #todo-stats:after {
		content: ""0"";
		display: block;
		height: 0;
		clear: both;
		overflow: hidden;
		visibility: hidden;
	  }
	  #todo-stats .todo-count {
		float: left;
	  }
		#todo-stats .todo-count .number {
		  font-weight: bold;
		  color: #333333;
		}
	  #todo-stats .todo-clear {
		float: right;
	  }
		#todo-stats .todo-clear a {
		  color: #777777;
		  font-size: 12px;
		}
		  #todo-stats .todo-clear a:visited {
			color: #777777;
		  }
		  #todo-stats .todo-clear a:hover {
			color: #336699;
		  }
	
	#instructions {
	  background: #eee;
	  border: 1px solid #ccc;
	  border-radius: 3px;
	  -moz-border-radius: 3px;
	  -webkit-border-radius: 3px;
	  margin: 15px auto auto 0px;
	  text-shadow: rgba(255, 255, 255, 0.8) 0 1px 0;
	  list-style-type: none;
	  padding: 5px 5px 5px 8px;
	}
	  #instructions li {
		margin-left: 0px;
		padding-left: 0px;
	  }
	
	#credits {
	  color: #999;
	  margin: 3px auto auto 0px;
	  text-shadow: rgba(255, 255, 255, 0.8) 0 1px 0;
	}
	  #credits a {
		color: #888;
	  }

## Step 6. The front-end logic

Save the following to `apps/todos/js/todos.js`.

	// An example Backbone application contributed by
	// [Jérôme Gravel-Niquet](http://jgn.me/).
	//
	// This demo was modified to integrate with the Elefant CMS
	// by [Johnny Broadway](http://github.com/jbroadway).
	
	// Load the application once the DOM is ready, using `jQuery.ready`:
	$(function(){
	
	  // Todo Model
	  // ----------
	
	  // Our basic **Todo** model has `text`, `order`, and `done` attributes.
	  window.Todo = Backbone.Model.extend({
	
		// Default attributes for a todo item.
		defaults: function() {
		  return {
			done:  false,
			order: Todos.nextOrder()
		  };
		},
	
		// Toggle the `done` state of this todo item.
		toggle: function() {
		  this.save({done: !this.get(""done"")});
		}
	
	  });
	
	  // Todo Collection
	  // ---------------
	
	  // The collection of todos.
	  window.TodoList = Backbone.Collection.extend({
	
		// Reference to this collection's model.
		model: Todo,
	
		// Save all of the todo items to Elefant at /todos/api/item.
		url: '/todos/api/item',
	
		// Filter down the list of all todo items that are finished.
		done: function() {
		  return this.filter(function(todo){ return todo.get('done'); });
		},
	
		// Filter down the list to only todo items that are still not finished.
		remaining: function() {
		  return this.without.apply(this, this.done());
		},
	
		// We keep the Todos in sequential order, despite being saved by unordered
		// GUID in the database. This generates the next order number for new items.
		nextOrder: function() {
		  if (!this.length) return 1;
		  return this.last().get('order') + 1;
		},
	
		// Todos are sorted by their original insertion order.
		comparator: function(todo) {
		  return todo.get('order');
		}
	
	  });
	
	  // Emulate HTTP since PHP has issues with PUT and DELETE.
	  Backbone.emulateHTTP = true;
	
	  // Create our global collection of **Todos**.
	  window.Todos = new TodoList;
	
	  // Todo Item View
	  // --------------
	
	  // The DOM element for a todo item...
	  window.TodoView = Backbone.View.extend({
	
		//... is a list tag.
		tagName:  ""li"",
	
		// Cache the template function for a single item.
		template: _.template($('#item-template').html()),
	
		// The DOM events specific to an item.
		events: {
		  ""click .check""              : ""toggleDone"",
		  ""dblclick div.todo-text""    : ""edit"",
		  ""click span.todo-destroy""   : ""clear"",
		  ""keypress .todo-input""      : ""updateOnEnter""
		},
	
		// The TodoView listens for changes to its model, re-rendering.
		initialize: function() {
		  this.model.bind('change', this.render, this);
		  this.model.bind('destroy', this.remove, this);
		},
	
		// Re-render the contents of the todo item.
		render: function() {
		  $(this.el).html(this.template(this.model.toJSON()));
		  this.setText();
		  return this;
		},
	
		// To avoid XSS (not that it would be harmful in this particular app),
		// we use `jQuery.text` to set the contents of the todo item.
		setText: function() {
		  var text = this.model.get('text');
		  this.$('.todo-text').text(text);
		  this.input = this.$('.todo-input');
		  this.input.bind('blur', _.bind(this.close, this)).val(text);
		},
	
		// Toggle the `""done""` state of the model.
		toggleDone: function() {
		  this.model.toggle();
		},
	
		// Switch this view into `""editing""` mode, displaying the input field.
		edit: function() {
		  $(this.el).addClass(""editing"");
		  this.input.focus();
		},
	
		// Close the `""editing""` mode, saving changes to the todo.
		close: function() {
		  this.model.save({text: this.input.val()});
		  $(this.el).removeClass(""editing"");
		},
	
		// If you hit `enter`, we're through editing the item.
		updateOnEnter: function(e) {
		  if (e.keyCode == 13) this.close();
		},
	
		// Remove this view from the DOM.
		remove: function() {
		  $(this.el).remove();
		},
	
		// Remove the item, destroy the model.
		clear: function() {
		  this.model.destroy();
		}
	
	  });
	
	  // The Application
	  // ---------------
	
	  // Our overall **AppView** is the top-level piece of UI.
	  window.AppView = Backbone.View.extend({
	
		// Instead of generating a new element, bind to the existing skeleton of
		// the App already present in the HTML.
		el: $(""#todoapp""),
	
		// Our template for the line of statistics at the bottom of the app.
		statsTemplate: _.template($('#stats-template').html()),
	
		// Delegated events for creating new items, and clearing completed ones.
		events: {
		  ""keypress #new-todo"":  ""createOnEnter"",
		  ""keyup #new-todo"":     ""showTooltip"",
		  ""click .todo-clear a"": ""clearCompleted""
		},
	
		// At initialization we bind to the relevant events on the `Todos`
		// collection, when items are added or changed. Kick things off by
		// loading any preexisting todos that might be saved in *localStorage*.
		initialize: function() {
		  this.input    = this.$(""#new-todo"");
	
		  Todos.bind('add',   this.addOne, this);
		  Todos.bind('reset', this.addAll, this);
		  Todos.bind('all',   this.render, this);
	
		  Todos.fetch();
		},
	
		// Re-rendering the App just means refreshing the statistics -- the rest
		// of the app doesn't change.
		render: function() {
		  this.$('#todo-stats').html(this.statsTemplate({
			total:      Todos.length,
			done:       Todos.done().length,
			remaining:  Todos.remaining().length
		  }));
		},
	
		// Add a single todo item to the list by creating a view for it, and
		// appending its element to the `<ul>`.
		addOne: function(todo) {
		  var view = new TodoView({model: todo});
		  this.$(""#todo-list"").append(view.render().el);
		},
	
		// Add all items in the **Todos** collection at once.
		addAll: function() {
		  Todos.each(this.addOne);
		},
	
		// If you hit return in the main input field, and there is text to save,
		// create new **Todo** model persisting it to *localStorage*.
		createOnEnter: function(e) {
		  var text = this.input.val();
		  if (!text || e.keyCode != 13) return;
		  Todos.create({text: text});
		  this.input.val('');
		},
	
		// Clear all done todo items, destroying their models.
		clearCompleted: function() {
		  _.each(Todos.done(), function(todo){ todo.destroy(); });
		  return false;
		},
	
		// Lazily show the tooltip that tells you to press `enter` to save
		// a new todo item, after one second.
		showTooltip: function(e) {
		  var tooltip = this.$("".ui-tooltip-top"");
		  var val = this.input.val();
		  tooltip.fadeOut();
		  if (this.tooltipTimeout) clearTimeout(this.tooltipTimeout);
		  if (val == '' || val == this.input.attr('placeholder')) return;
		  var show = function(){ tooltip.show().fadeIn(); };
		  this.tooltipTimeout = _.delay(show, 1000);
		}
	
	  });
	
	  // Finally, we kick things off by creating the **App**.
	  window.App = new AppView;
	
	});

This is almost exactly the same as the Backbone.js example, with two exceptions:

1. We've replaced `localStorage: new Store(""todos"")` with this line that tells
Backbone.js to connect to `/todos/api/item` on the server:

	url: '/todos/api/item'

2. We've added this line because PHP doesn't handle PUT and DELETE requests
without jumping through extra hoops configuring your web server:

	Backbone.emulateHTTP = true;

## Step 7. Connecting it to the back-end

### The Model

You can use the Elefant [DB Manager](http://github.com/jbroadway/dbman) app to
install the following database schema.

For SQLite, use:

	create table `todo` (
		`id` integer primary key,
		`text` char(128) not null,
		`done` int not null,
		`order` int not null
	);
	
	create index `todo_order` on `todo` (`order`);

For MySQL, use:

	create table `todo` (
		`id` int not null auto_increment primary key,
		`text` char(128) not null,
		`done` int not null,
		`order` int not null,
		index (`order`)
	);

Now we can define our Model in `apps/todos/models/Todo.php` as follows:

	<?php
	
	class Todo extends Model {}
	
	?>

### Our REST handler

Here is the complete `/todos/api/item` REST handler that you can save to `apps/todos/lib/TodoApi.php`.
This is a class that extends Elefant's `Restful` helper class. We'll connect it in a handler afterwards.

	<?php
	
	class TodoApi extends Restful {
		/**
		 * Don't wrap output in `{""success"":bool,""data"":""...""}`.
		 */
		var $wrap = false;
	
		/**
		 * Create a new item.
		 */
		public function post_item () {
			$obj = $this->get_raw_post_data (true);
			$obj->done = ($obj->done) ? 1 : 0;
			$todo = new Todo ($obj);
			if (! $todo->put ()) {
				return $this->error ($todo->error);
			}
			$out = $todo->orig ();
			$out->done = ($out->done == 1) ? true : false;
			return $out;
		}
	
		/**
		 * Get one or more items.
		 */
		public function get_item ($id = false) {
			if ($id) {
				// get one item
				$todo = new Todo ($id);
				if ($todo->error) {
					return $this->error ($todo->error);
				}
				$out = $todo->orig ();
				$out->done = ($out->done == 1) ? true : false;
				return $out;
			}
	
			// get all items
			$out = array ();
			$list = Todo::query ()
				->order ('`order` asc')
				->fetch_orig ();
	
			if (is_array ($list)) {
				foreach ($list as $item) {
					$item->done = ($item->done == 1) ? true : false;
					$out[] = $item;
				}
			}
			return $out;
		}
	
		/**
		 * Update the specified item.
		 */
		public function put_item ($id) {
			$todo = new Todo ($id);
			$data = $this->get_put_data (true);
			$todo->text = $data->text;
			$todo->done = ($data->done) ? 1 : 0;
			$todo->order = $data->order;
			if (! $todo->put ()) {
				return $this->error ($todo->error);
			}
			$out = $todo->orig ();
			$out->done = ($out->done == 1) ? true : false;
			return $out;
		}
	
		/**
		 * Delete the specified item.
		 */
		public function delete_item ($id) {
			$todo = new Todo ($id);
			if (! $todo->remove ()) {
				return $this->error ($todo->error);
			}
			return $id;
		}
	
		/**
		 * Overriding `error()` to log info.
		 */
		public function error ($msg) {
			error_log (sprintf ('%s %s: %s', $this->controller->request_method (), $_SERVER['REQUEST_URI'], $msg));
			return false;
		}
	}
	
	?>

For info on how the class works, see the [[RESTful APIs]] page.

Now to connect our API, we'll create a handler named `apps/todos/handlers/api.php` with the following:

	<?php
	
	$this->restful (new TodoApi);
	
	?>

Elefant will take care of routing requests to the right methods of our class based on the request method and URL.

That's all there is to creating a RESTful API in Elefant to work with Backbone.js-powered
front-end applications. For more information on building APIs in Elefant, see [[RESTful APIs]].