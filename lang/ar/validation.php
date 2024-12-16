<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */
    'accepted' => 'يجب قبول :attribute',
    'active_url' => ':attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون :attribute ًمصفوفة',
    'before' => 'يجب على :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => ':attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما true أو false ',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date' => ':attribute ليس تاريخًا صحيحًا',
    'date_format' => 'لا يتوافق :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام ',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'exists' => ':attribute مطلوب',
    'file' => 'الـ :attribute يجب أن يكون ملفا.',
    'filled' => ':attribute إجباري',
    'image' => 'يجب أن يكون :attribute صورةً',
    'in' => ':attribute مطلوب',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيحًا',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيحًا.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيحًا.',
    'json' => 'يجب أن يكون :attribute نصآ من نوع JSON.',
    'max' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أصغر لـ :max.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية أو أكبر لـ :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
    ],
    'not_in' => ':attribute مطلوب',
    'numeric' => 'يجب على :attribute أن يكون رقمًا',
    'present' => 'يجب تقديم :attribute',
    'regex' => 'صيغة :attribute .غير صحيحة',
    'required' => ':attribute مطلوب.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
    'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
    ],
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => 'قيمة :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل الـ :attribute',
    'url' => 'صيغة الرابط :attribute غير صحيحة',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    'attributes' => [
        "role"=>"صلاحية",
        "products"=>"المنتجات",
        "users"=>"المستخدمين",
        "category_id"=>"القسم",
        "current_password"=>"كلمة المرور الحاليه",
        "store.name"=>"إسم المرسل",
        "store.address_name"=>"عنوان المرسل",
        "store.email"=>"البريد الإلكتروني",
        "store.phone"=>"رقم الجوال",
        "store.city"=>"المدينه",
        "customer.name"=>"إسم المستلم",
        "customer.address_name"=>"عنوان المستلم",
        "customer.email"=>"البريد الإلكتروني",
        "customer.phone"=>"رقم الجوال",
        "customer.city"=>"المدينه",
        "weight"=>"وزن الشحنه",
        "bank_id"=>"البنك",
        "user_data.account_name"=>"إسم الحساب",
        "user_data.account_number"=>"رقم الحساب",
        "user_data.iban"=>"رقم الايبان",
        "user_data.transfer_number"=>"رقم إيصال التحويل",
        "user_data.transfer_image"=>"صوره إيصال التحويل",
        "commercial_registration"=>"حقل رقم السجل",
        'store_name' => 'حقل إسم المتجر',
        'name' => 'حقل الاسم',
        'avatar' => 'حقل الصوره',
        'username' => 'حقل اسم المُستخدم',
        'email' => 'حقل البريد الالكتروني',
        'first_name' => 'حقل الاسم الأول',
        'last_name' => 'حقل اسم العائلة',
        'password' => 'حقل كلمة السر',
        'password_confirmation' => 'حقل تأكيد كلمة السر',
        'city' => 'حقل المدينة',
        'country' => 'حقل الدولة',
        'address' => 'حقل عنوان السكن',
        'phone' => 'حقل الجوال',
        'age' => 'حقل العمر',
        'sex' => 'حقل الجنس',
        'gender' => 'حقل النوع',
        'day' => 'حقل اليوم',
        'month' => 'حقل الشهر',
        'year' => 'حقل السنة',
        'hour' => 'حقل ساعة',
        'minute' => 'حقل دقيقة',
        'second' => 'حقل ثانية',
        'title' => 'حقل العنوان',
        'content' => 'حقل المُحتوى',
        'description' => 'حقل الوصف',
        'excerpt' => 'حقل المُلخص',
        'date' => 'حقل التاريخ',
        'time' => 'حقل الوقت',
        'available' => 'حقل مُتاح',
        'size' => 'حقل الحجم',
        'image' => 'حقل الصوره',
        'category' => 'حقل القسم',
        'duration' => 'حقل المده',
        'type' => 'حقل النوع',
        'images.0' => 'حقل الصور',
        'images' => 'حقل الصور',
        'comment' => 'حقل التعليق',
        'flag' => 'حقل صورة العلم',
        'code' => 'حقل الكود',
        'link' => 'حقل الرابط',
        'facebook_link' => 'حقل رابط فيسبوك',
        'twitter_link' => 'حقل رابط تويتر',
        'pinterest_link' => 'حقل رابط بينتريست',
        'youtube_link' => 'حقل رابط يوتيوب',
        'insta_link' => 'حقل رابط الانستجرام',
        'google_link' => 'حقل رابط جوجل',
        'logo' => 'حقل اللوجو',
        'logo_title' => 'حقل عنوان الموقع',
        'site_phone' => 'حقل هاتف الموقع',
        'site_email' => 'حقل بريد الموقع',
        'terms_of_use' => 'حقل شروط الاستخدام',
        'privacy_policy' => 'حقل شروط الخصوصيه',
        'subject' => 'حقل الموضوع',
        'message' => 'حقل الرساله',
        'user_type' => 'حقل الطرف',
        'id_number' => 'حقل رقم الهويه',
        'price' => 'حقل السعر',
        'from_date' => 'حقل تاريخ البدايه',
        'to_date' => 'حقل تاريخ الانتهاء',
        'info' => 'حقل معلومات اضافيه',
        'agreement' => 'حقل الموافقه على شروط الاستخدام ',
        'system_name' =>'إسم النظام',
        'omola' =>'عموله الموقع',
        'bank_name' =>'إسم البنك',
        'bank_logo' =>'شعار البنك',
        'account_name' =>'إسم صاحب الحساب',
        'account_number' =>'رقم الحساب',
        'iban' =>'ايبان',
        'icon' =>'أيكون موقع التواصل',
        'user_img'=>'برجاء إدخال صوره شخصيه',
        'fullname'=>'إسم المستخدم',
        'search_txt'=>'برجاء إدخال بيانات البحث',
        'adv_title'=>'العنوان الرئيسي للإعلان',
        'adv_content'=>'التفاصيل الإعلان',
        'country_id'=>'الدوله',
        'town_id'=>'المدينه',
        'cat_option'=>'الإختيارات',
        'check' =>'اتعهد ان اقوم بدفع عمولة الموقع',
        'def_img'=>'الصوره الرئيسيه',

    ],
];