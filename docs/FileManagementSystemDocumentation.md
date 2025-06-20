توثيق نظام إدارة الملفات والصور
نظرة عامة
نظام إدارة الملفات والصور هو نظام ديناميكي ومرن تم بناؤه باستخدام Laravel 12 مع Jetstream وSpatie Laravel Permission. يهدف النظام إلى توفير حل شامل لتخزين الصور والملفات، تحديثها، وحذفها، مع دعم إدارة المجلدات عبر صفحة مخصصة. النظام يتبع مبادئ SOLID وClean Code، مما يجعله قابلًا للصيانة والتوسع.
ميزات النظام

تخزين الصور:
تخزين صورة واحدة (مثل صورة البروفايل).
تخزين صور متعددة (مثل صور المنتجات).


تحديث الصور:
تحديث صورة واحدة بناءً على معرفها (media_id).
تحديث جميع الصور المرتبطة بنوع معين (مثل product_image).


حذف الصور:
حذف صورة واحدة بناءً على معرفها.
حذف جميع الصور المرتبطة بنوع معين.


إدارة الملفات والمجلدات:
صفحة مخصصة (/file-manager) للسوبر أدمن لعرض الملفات، المجلدات، وإدارتها (حذف، تحديث).


استراتيجيات التخزين:
MorphMediaStorage: يستخدم جدول media مع علاقة Morph لتخزين الصور المرتبطة بأي نموذج.
SingleColumnStorage: يخزن مسار الصورة في حقل معين بجدول النموذج (مثل profile_photo في users).
DedicatedTableStorage: يستخدم جدولًا مخصصًا (مثل product_images) لتخزين الصور.


الأمان:
التحقق من الصلاحيات عبر Middleware (auth, role:super-admin, permission:manage-files).
التحقق من صحة الملفات (نوع، حجم) عبر Request Classes.


الأداء:
تحميل العلاقات بفعالية (Eager Loading) في /file-manager.
تقليل التكرار باستخدام Facade وخدمات موحدة.



هيكلية النظام

MediaController: يوفر واجهة HTTP لتحميل، تحديث، وحذف الملفات.
MediaService: ينسق بين استراتيجيات التخزين (MorphMediaStorage, SingleColumnStorage, DedicatedTableStorage) عبر واجهة FileStorage.
Media Facade: يبسط الوصول إلى MediaService في الكونترولرز والخدمات.
FileManagerController: يدير صفحة /file-manager لعرض وحذف الملفات والمجلدات.
جدول media: يخزن مسارات الملفات مع علاقة Polymorphic (mediable_id, mediable_type).
Request Classes: تتحقق من صحة البيانات لكل عملية (StoreSingleMediaRequest, StoreMultipleMediaRequest, إلخ).

كيفية استخدام النظام
1. إعداد النظام

تثبيت التبعيات:composer install
php artisan migrate
php artisan storage:link


إضافة صلاحية إدارة الملفات:php artisan tinker
\Spatie\Permission\Models\Permission::create(['name' => 'manage-files']);
$role = \Spatie\Permission\Models\Role::findByName('super-admin');
$role->givePermissionTo('manage-files');


مسح ذاكرة التخزين المؤقت:php artisan cache:clear
php artisan config:clear
php artisan route:clear
composer dump-autoload



2. استخدام MediaController عبر طلبات HTTP
MediaController يوفر النقاط التالية لإدارة الملفات عبر طلبات HTTP (مثل نماذج Blade أو AJAX).
2.1. تخزين صورة واحدة

المسار: POST /media/single
الوصف: يخزن صورة واحدة مرتبطة بنموذج معين (مثل منتج أو مستخدم).
المدخلات:
file: ملف الصورة (مطلوب، يدعم jpeg, png, jpg, gif, ico، بحد أقصى 2MB).
model_id: معرف النموذج (مثل ID المنتج).
model_type: نوع النموذج (مثل App\Models\Product).
type: نوع الصورة (مثل product_image).
path: مسار التخزين (اختياري، الافتراضي media).


مثال توضيحي (نموذج Blade):<form action="{{ route('media.storeSingle') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept="image/*">
    <input type="hidden" name="model_id" value="1">
    <input type="hidden" name="model_type" value="App\Models\Product">
    <input type="hidden" name="type" value="product_image">
    <input type="text" name="path" value="products" placeholder="مسار التخزين">
    <button type="submit">تحميل الصورة</button>
</form>


مثال توضيحي (طلب AJAX):const formData = new FormData();
formData.append('file', document.querySelector('#fileInput').files[0]);
formData.append('model_id', 1);
formData.append('model_type', 'App\\Models\\Product');
formData.append('type', 'product_image');
formData.append('path', 'products');

fetch('/media/single', {
    method: 'POST',
    body: formData,
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
}).then(response => response.json()).then(data => console.log(data.message));



2.2. تخزين صور متعددة

المسار: POST /media/multiple
الوصف: يخزن عدة صور مرتبطة بنموذج معين.
المدخلات:
files[]: مصفوفة من الملفات (مطلوب، نفس قيود file أعلاه).
model_id, model_type, type, path: نفس المدخلات أعلاه.


مثال توضيحي (نموذج Blade):<form action="{{ route('media.storeMultiple') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="files[]" accept="image/*" multiple>
    <input type="hidden" name="model_id" value="1">
    <input type="hidden" name="model_type" value="App\Models\Product">
    <input type="hidden" name="type" value="product_image">
    <input type="text" name="path" value="products">
    <button type="submit">تحميل الصور</button>
</form>



2.3. تحديث صورة واحدة

المسار: PUT /media/{mediaId}
الوصف: يحدث صورة معينة بناءً على معرفها في جدول media.
المدخلات:
file: ملف الصورة الجديد.
path: مسار التخزين (اختياري).


مثال توضيحي (نموذج Blade):<form action="{{ route('media.update', 1) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="file" name="file" accept="image/*">
    <input type="text" name="path" value="products">
    <button type="submit">تحديث الصورة</button>
</form>



2.4. حذف صورة واحدة

المسار: DELETE /media/{mediaId}
الوصف: يحذف صورة معينة بناءً على معرفها.
المدخلات: لا يوجد (معرف الصورة يتم تمريره في المسار).
مثال توضيحي (نموذج Blade):<form action="{{ route('media.destroy', 1) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" onclick="return confirm('هل أنت متأكد؟')">حذف الصورة</button>
</form>



3. استخدام Media Facade
الـ Facade (\App\Facades\Media) يبسط استخدام MediaService في الكونترولرز والخدمات. يستخدم استراتيجية MorphMediaStorage افتراضيًا.
3.1. تخزين صورة واحدة

الدالة: Media::storeSingle($file, $model, $type, $path)
الوصف: يخزن صورة واحدة مرتبطة بنموذج.
مثال توضيحي (في كونترولر):use App\Facades\Media;
use App\Models\Product;
use Illuminate\Http\Request;

public function addImage(Request $request, Product $product)
{
    $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    Media::storeSingle($request->file('image'), $product, 'product_image', 'products');
    return redirect()->back()->with('success', 'تم إضافة الصورة.');
}



3.2. تخزين صور متعددة

الدالة: Media::storeMultiple($files, $model, $type, $path)
الوصف: يخزن عدة صور مرتبطة بنموذج.
مثال توضيحي:public function addImages(Request $request, Product $product)
{
    $request->validate(['images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    Media::storeMultiple($request->file('images'), $product, 'product_image', 'products');
    return redirect()->back()->with('success', 'تم إضافة الصور.');
}



3.3. تحديث صورة واحدة

الدالة: Media::updateMedia($file, $mediaId, $path)
الوصف: يحدث صورة معينة بناءً على معرفها.
مثال توضيحي:public function updateImage(Request $request, $mediaId)
{
    $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    Media::updateMedia($request->file('image'), $mediaId, 'products');
    return redirect()->back()->with('success', 'تم تحديث الصورة.');
}



3.4. حذف صورة واحدة

الدالة: Media::deleteSingle($mediaId)
الوصف: يحذف صورة معينة بناءً على معرفها.
مثال توضيحي:public function deleteImage($mediaId)
{
    Media::deleteSingle($mediaId);
    return redirect()->back()->with('success', 'تم حذف الصورة.');
}



3.5. تحديث صورة بنوع معين

الدالة: Media::updateSingle($file, $model, $type, $path)
الوصف: يحذف جميع الصور المرتبطة بنوع معين ويخزن صورة جديدة.
مثال توضيحي:public function updateProfilePhoto(Request $request, User $user)
{
    $request->validate(['photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    Media::updateSingle($request->file('photo'), $user, 'profile_photo', 'profiles');
    return redirect()->back()->with('success', 'تم تحديث صورة البروفايل.');
}



3.6. حذف صور بنوع معين

الدالة: Media::delete($model, $type)
الوصف: يحذف جميع الصور المرتبطة بنوع معين لنموذج.
مثال توضيحي:public function deleteProductImages(Product $product)
{
    Media::delete($product, 'product_image');
    return redirect()->back()->with('success', 'تم حذف صور المنتج.');
}



4. استخدام استراتيجيات تخزين أخرى
لاستخدام استراتيجية تخزين غير MorphMediaStorage (مثل SingleColumnStorage أو DedicatedTableStorage)، قم بإنشاء مثيل يدوي من MediaService:
4.1. SingleColumnStorage

الوصف: يخزن الصورة في حقل معين بجدول النموذج (مثل profile_photo في users).
مثال توضيحي:use App\Services\MediaService;
use App\Services\Storage\SingleColumnStorage;

public function updateProfile(Request $request, User $user)
{
    $request->validate(['photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    $mediaService = new MediaService(new SingleColumnStorage('profile_photo'));
    $mediaService->storeSingle($request->file('photo'), $user, 'profile_photo', 'profiles');
    return redirect()->back()->with('success', 'تم تحديث صورة البروفايل.');
}



4.2. DedicatedTableStorage

الوصف: يخزن الصور في جدول مخصص (مثل product_images).
مثال توضيحي:use App\Services\MediaService;
use App\Services\Storage\DedicatedTableStorage;

public function addProductImages(Request $request, Product $product)
{
    $request->validate(['images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    $mediaService = new MediaService(new DedicatedTableStorage('product_images', 'path', 'product_id'));
    $mediaService->storeMultiple($request->file('images'), $product, 'product_image', 'products');
    return redirect()->back()->with('success', 'تم إضافة صور المنتج.');
}



5. إدارة الملفات عبر /file-manager

الوصف: صفحة مخصصة للسوبر أدمن لعرض الملفات والمجلدات، تحديث الصور، وحذفها.
المسار: GET /file-manager
الصلاحيات: يتطلب دور super-admin وصلاحية manage-files.
الميزات:
عرض المجلدات في التخزين العام (storage/app/public).
عرض الصور المرتبطة في جدول media مع تفاصيل النموذج المالك.
تحديث صورة عبر نموذج تحميل.
حذف صورة عبر زر حذف.


مثال توضيحي (كيفية الوصول):
سجل الدخول كـ super-admin.
انتقل إلى /file-manager.
لتحديث صورة:
انقر على حقل التحميل بجوار الصورة، اختر ملفًا جديدًا، وسيتم التحديث تلقائيًا.


لحذف صورة:
انقر على زر "حذف" بجوار الصورة وأكد العملية.





6. ملاحظات إضافية

الأداء:
يتم تحميل العلاقات (mediable) بفعالية في /file-manager باستخدام Eager Loading.
التحقق من صحة البيانات في Request Classes يقلل من الأخطاء.


الأمان:
جميع العمليات محمية بـ Middleware للتحقق من الصلاحيات.
يتم التحقق من نوع وحجم الملفات قبل التخزين.


التوسعية:
يمكن إضافة استراتيجيات تخزين جديدة (مثل S3) بتنفيذ واجهة FileStorage.
يمكن تحسين /file-manager بإضافة ميزات مثل إنشاء مجلدات أو البحث.


التوافق مع SOLID:
النظام يفصل المسؤوليات (SRP)، مفتوح للتوسع (OCP)، يدعم الاستبدال (LSP)، يستخدم واجهات محددة (ISP)، ويعتمد على التجريدات (DIP).



مثال شامل
لتوضيح استخدام النظام، لنفترض أن لديك منتجًا (Product) وتريد إدارة صوره:

إنشاء منتج جديد مع صور:
use App\Facades\Media;
use App\Models\Product;

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = Product::create(['name' => $request->name]);
    Media::storeMultiple($request->file('images'), $product, 'product_image', 'products');
    return redirect()->route('products.index')->with('success', 'تم إنشاء المنتج.');
}


إضافة صورة إضافية:
public function addImage(Request $request, Product $product)
{
    $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    Media::storeSingle($request->file('image'), $product, 'product_image', 'products');
    return redirect()->back()->with('success', 'تم إضافة الصورة.');
}


تحديث صورة موجودة:
public function updateImage(Request $request, $mediaId)
{
    $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048']);
    Media::updateMedia($request->file('image'), $mediaId, 'products');
    return redirect()->back()->with('success', 'تم تحديث الصورة.');
}


حذف صورة واحدة:
public function deleteImage($mediaId)
{
    Media::deleteSingle($mediaId);
    return redirect()->back()->with('success', 'تم حذف الصورة.');
}


إدارة الملفات كسوبر أدمن:

انتقل إلى /file-manager.
اعرض الصور المرتبطة بالمنتج، حدث صورة، أو احذفها.



استكشاف الأخطاء

خطأ "Model not found":
تأكد من أن model_id وmodel_type صحيحان في طلبات storeSingle أو storeMultiple.


خطأ "Permission denied":
تحقق من أن المستخدم لديه الصلاحيات المطلوبة (مثل manage-files لـ /file-manager).


خطأ "File not uploaded":
تأكد من أن حقل file أو files[] مرسل بشكل صحيح ويتوافق مع قيود التحقق.



للحصول على دعم إضافي، راجع الكود المصدري في app/Services/MediaService.php وapp/Http/Controllers/MediaController.php.
