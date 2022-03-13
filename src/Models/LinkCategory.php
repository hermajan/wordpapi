<?php

namespace Wordpapi\Models;

use Wordpapi\Models\Fields\{Description, Id, Slug};

class LinkCategory extends Model {
	use Id, Description, Slug;
}
