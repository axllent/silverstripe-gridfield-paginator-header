<?php

SS_Object::add_extension('ModelAdmin', 'GridFieldPaginatorHeaderExtension');

LeftAndMain::require_css(basename(dirname(__FILE__)) . '/css/paginatorheader.css');
