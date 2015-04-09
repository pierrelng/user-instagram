<?php

/*
Imagick Extended Image Editor with sepia nad greyscale methods
*/

class User_Insta_Imagick_Filters_Editor extends WP_Image_Editor_Imagick {
	public function sepia( $arg = 100 ) {
		$this->image->sepiaToneImage( $arg );

		return true;
	}

	public function greyscale() {
		$this->image->modulateImage( 100, 0, 100 );

		return true;
	}
}

/*
GD Extended Image Editor with sepia nad greyscale methods
*/

class User_Insta_GD_Filters_Editor extends WP_Image_Editor_GD {
	public function sepia() {
		imagefilter( $this->image, IMG_FILTER_GRAYSCALE );
		imagefilter( $this->image, IMG_FILTER_COLORIZE, 90, 60, 40 );

		return true;
	}

    public function negate() {
        imagefilter( $this->image, IMG_FILTER_NEGATE );

        return true;
    }

	public function greyscale() {
		imagefilter( $this->image, IMG_FILTER_GRAYSCALE );
		return true;
	}

	public function red() {
		imagefilter( $this->image, IMG_FILTER_COLORIZE, 255, 100, 100 );
		return true;
	}

	public function pixelate() {
		imagefilter( $this->image, IMG_FILTER_PIXELATE, 40, true );
		return true;
	}

	public function emboss() {
		imagefilter( $this->image, IMG_FILTER_EMBOSS );
		return true;
	}

}