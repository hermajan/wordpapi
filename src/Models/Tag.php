<?php

namespace Wordpapi\Models;

use Wordpapi\Models\Fields\{Description, Id, Slug};

class Tag extends Model {
	use Id, Description, Slug;
}
