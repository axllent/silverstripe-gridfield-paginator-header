<?php

/*
 * Adds pagination into the header of a gridfield (modeladmin)
 * Kudos to Jean-Fabien Barrois for the code!
 */

class GridFieldPaginatorHeaderExtension extends Extension {

	public function updateEditForm(Form $form) {
		$gf = clone $form->Fields()->First(); // naughty... we assume the GF is the sole field
		$config = $form->Fields()->First()->getConfig();
		$config->removeComponentsByType('GridFieldPageCount');
		$config->addComponent(new GridFieldPaginatorHeader($this->owner->stat('page_length')));
	}

}


class GridFieldPaginatorHeader extends GridFieldPaginator {

	protected function getPaginator($gridField) {
		$paginator = $gridField->getConfig()->getComponentByType('GridFieldPaginator');

		if(!$paginator && self::$require_paginator) {
			throw new LogicException(
				get_class($this) . " relies on a GridFieldPaginator to be added " .
				"to the same GridField, but none are present."
			);
		}

		return $paginator;
	}

	/**
	* @param GridField $gridField
	* @return array
	*/
	public function getHTMLFragments($gridField) {
		// Retrieve paging parameters from the directing paginator component
		$paginator = $this->getPaginator($gridField);
		if ($paginator && ($forTemplate = $paginator->getTemplateParameters($gridField))) {
			return array(
				'toolbar-header-left' => $forTemplate->renderWith($this->itemClass,
				array('Colspan'=>count($gridField->getColumns())))
			);
		}
	}

}
