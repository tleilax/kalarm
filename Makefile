build: css js

css:
#	recess --compile assets/styles.less > assets/styles.css
	recess --compress assets/styles.less > assets/styles.css

js:
#	coffee --compile --print --bare ./assets/application.coffee > ./assets/application.js
	uglifyjs vendor/flot/jquery.js vendor/flot/jquery.flot.js vendor/flot/jquery.flot.time.js assets/script.js --output assets/application.js

