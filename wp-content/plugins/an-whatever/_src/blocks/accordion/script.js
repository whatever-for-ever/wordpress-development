/*
 *   This content is licensed according to the W3C Software License at
 *   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
 *
 *   Simple accordion pattern example.
 */

'use strict';

import domReady from '@wordpress/dom-ready';

class Accordion {
	constructor( domNode ) {
		this.rootEl = domNode;
		this.buttonEl = this.rootEl.querySelector( 'button[aria-expanded]' );

		const controlsId = this.buttonEl.getAttribute( 'aria-controls' );
		this.contentEl = document.getElementById( controlsId );

		this.open = this.buttonEl.getAttribute( 'aria-expanded' ) === 'true';

		// add event listeners.
		this.buttonEl.addEventListener(
			'click',
			this.onButtonClick.bind( this )
		);
	}

	onButtonClick() {
		this.toggle( ! this.open );
	}

	toggle( open ) {
		// don't do anything if the open state doesn't change.
		if ( open === this.open ) {
			return;
		}

		// update the internal state.
		this.open = open;

		// handle DOM updates
		this.buttonEl.setAttribute( 'aria-expanded', `${ open }` );
		if ( open ) {
			this.contentEl.removeAttribute( 'hidden' );
		} else {
			this.contentEl.setAttribute( 'hidden', '' );
		}
	}

	// Add public open and close methods for convenience.
	open() {
		this.toggle( true );
	}

	close() {
		this.toggle( false );
	}
}

domReady( function () {
	initBlockViewAndEditorScripts();
} );

function initBlockViewAndEditorScripts() {
	console.log( 'Accordion front-end and back-end script loaded' );

	// init accordions.
	const accordions = document.querySelectorAll(
		'.wp-block-an-whatever-accordion-item h3'
	);

	accordions.forEach( ( accordionEl ) => {
		new Accordion( accordionEl );
	} );
}
