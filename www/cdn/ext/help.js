var g_read_str = '\
      <font color="#FF0000" size="4">如果已经开通了OSS图片处理服务</font>\
      <br>请在图片源信息里面，在域名里填入您开通图片处理服务绑定的域名， 在文件名里面填入object 名称\
      <br><font color="#FF0000" size="4">如果我没有开通OSS图片处理服务</font>\
      <br>您可以通过我们预先设置好的域名进行体验， 请点击[试用], 这里会有一个测试域名，让您体验一下OSS图片处理服务的功能！\
      <br><font color="#FF0000" size="4">如果我想要更加高级的功能，如创建样式。设置属性。我要怎么样操作？（只想查看缩略结果的，忽略这一步）</font>\
      <br>第一步：您必须开通该bucket对应的Cors服务。因为这个是一个html,因为浏览器安全设定，必须设置Cors后，请求才能发送。设置方法是：在OSS控制台，在Bucket属性里面，Cors设置里面，所要设置Cors如下图：（来源：＊， Allowed Header：＊， Method:GET, PUT)\
      <img src="./ext/cors1.png"/>\
      <br>第二步：管理按钮下面设置Id/Key, 然后可以在管理按钮下选择您想要的操作。\
      <br><font color="#0000FF" size="2">该工具由MoonShine开发，全部开源！！感谢EXT，感谢阿里云！\
      <br><br>'

var g_param_str = '\
      <br><font color="#FF0000" size="4">只允许用样式</font>\
      <br>不允许直接用参数操作（即@100w这类的操作）只允许用样式或者原图\
      <br>styleonly.oss-demo.com 设置了只允许用样式。有样式abc，样式内容是:100w \
      <br>styleonly.oss-demo.com/example.jpg是可以访问\
      <br>styleonly.oss-demo.com/example.jpg@!abc(style是我的样式名称) 是可以访问\
      <br>styleonly.oss-demo.com/example.jpg@100w 不允许访问，直接带处理参数是不允许的.\
      <br><font color="#FF0000" size="4">禁止访问原图</font>\
      <br>origforbid.oss-demo.com设置了禁止访问原图。\
      <br>那么origforbid.oss-demo.com/example.jpg 是不可以访问的\
      <br>origforbid.oss-demo.com/example.jpg＠!abc是可以访问的\
      <br>styleonly.oss-demo.com/example.jpg@100w也是可以访问的。\
      <br><font color="#FF0000" size="3">注意禁止访问原图可以和只允许用样式搭配使用。如果您使用了CDN。某些URL可能按上述结果修改完没有生效。请刷新CDN Cache后重试！！</font>\
      <br><font color="#FF0000" size="4">自动设置ContentType</font>\
      <br>如果在上传的时候，没有指定Content-Type或者设置了错误的ContentType. 设置这个参数。可以让OSS图片处理服务在您下载原图时，帮您指定好该图片正确的ContentType.（注意：对图进行处理，默认就会设置ContentType)\
      <br><font color="#FF0000" size="4">不填格式，按原图返回</font>\
      <br>OSS图片处理服务的逻辑是，如果不填格式。默认按jpg返回，导致一些png图转成jpg会出错。设置这个参数。如果原图是什么格式，处理后就是什么格式（注意:如果原图是gif,默认按jpg的返回，不是gif)\
      <br>如果origforbid.oss-demo.com 设置不填格式，返回按原图访问\
      <br>origforbid.oss-demo.com/panda.png@100w，处理后的格式是png, img.oss-demo.com没有设置该参数, img.oss-demo.com/panda.png@100w 处理后的格式是jpg\
      <br><font color="#FF0000" size="4">404缺省图片</font>\
      <br>如果设置了该参数。那么当访问一张不存在图片时，会按这张设置的图片返回。\
      <br>如styleonly.oss-demo.com 设置了该参数。styleonly.oss-demo.com/asdgadgasg 没有存在asdgadgasg这个文件，都会返回一张默认的404图片\
      <br><font color="#FF0000" size="4">自动设置下载名</font>\
      <br>设置了这个参数，会自动设置了下载名字。如在不设置的情况，请求img.oss-demo.com/example.jpg@100w，另存为，文件名是example.jpg@100w 这样会导致windows下载后，不认识这个文件，因为后缀名不对。如果设置了这个参数。如origforbid.oss-demo.com保存下来的文件名就是example.jpg \
      <br><font color="#FF0000" size="4">自定义样式分隔符</font>\
      <br>目前OSS图片处理支持的样式分隔符是@!, 用户可以通过这个参数指定。如styleonly.oss-demo.com 指定了样式分隔符是-(中划线). 那么styleonly.oss-demo.com-abc 跟styleonly.oss-demo.com@!abc的效果是一致的\
      <br><br>'


var g_help_str ='\
      <br><br><font color="#FF0000">我对参数不理解怎么办？</font>\
      <br>参考官方文档：http://docs.aliyun.com/#/oss/oss-img-api/intruduction&brief\
      <br><br><font color="#FF0000">为什么点击生成效果图之后，在右边图片的框里显示不出来？</font>\
      <br><font color="#FF00FF">域名配置不对</font>\
      <br>点击<b>在浏览器打开</b>， 看一下指示文档错误信息: NoSuchFile. 那点击<b>显示原图</b>. <br>如果图片能显示说明，该域名绑定成功.\
      有可能绑定图片服务不成功。请确认一下,您绑定OSS的域名跟绑定图片服务的域名是不是同一个.\
      因为按OSS文档：绑定图片服务的域名跟绑定OSS的域名不能是同一个。\
　　　<br>如果图片不能显示，有可能是没有object, 请确认一下object 的拼写是否正确\
　　　<br>如果图片不能显示，有可能是图片水印object没有找到, 请确认一下object 的拼写是否正确\
      <br><font color="#FF00FF">使用参数出错：</font>\
　　　<br>点击“在浏览器打开”， 看一下指示文档错误信息。\
　　　<br>如果错误信息是：Advance cut position is out of image.\
      <br>&nbsp;&nbsp;这是在选择<b>缩放类型－指定裁剪</b>，　输入的x,y值大于原图的尺寸。\
　　　<br>如果错误信息是：Advance cut range is out of image.\
      <br>&nbsp;&nbsp;这是在选择<b>缩放类型－指定裁剪</b>，　输入的高度和宽度大于原图的尺寸，推荐使用width=0, height=0 默认裁剪到图片边缘。\
　　　<br>如果错误信息是:The input width/height must be less than image width/height\
　　　<br>&nbsp;&nbsp;这是选择<b>固定宽高</b>时，从中间裁剪，输入的宽度和高度大于原图的尺寸导致的。\
　　　<br>如果错误信息是：The value: 4097 of parameter: w is invalid.\
　　　<br>&nbsp;&nbsp;这是因为输入的<b>缩略宽度</b>和<b>缩略高度</b>范围是：0-4096\
      <br>如果错误信息是：The value: 40000 of parameter: size is invalid.\
      <br>&nbsp;&nbsp;这是文字水印字体大小参数不对，字体的<b>大小</b>范围是：(0, 1000]\
      <br>如果错误信息是：The value: #00000t of parameter: color is invalid.\
      <br>&nbsp;&nbsp;这是文字水印颜色格式不对，颜色的格式错误，必须是：＃000000\
      <br><font color="#FF00FF">格式问题：</font>\
　　　<br>如果你保存成的格式是webp, 那么在非Chrome浏览器是打不开的，其中的原因可以自己google。所以推荐使用chrome浏览器。\
      <br><br><font color="#FF0000">为什么url里面会有多出来一个@？</font>\
      <br>＠是处理分隔符, 表示@后面的字符是图片的处理参数。 尽量不要让您的object 名字后面有@.\
      <br><br><font color="#FF0000">为什么字体内容等一些字段的内容在url里面变成了乱码了？</font>\
      <br>这不是乱码，这是对内容进行url 安全编码。\
      <br>(1)先将内容编码成 Base64 结果;\
      <br>(2)将结果中的加号”+”替换成中划线”-”\
      <br>(3)将结果中的斜杠”/”替换成下划线”_”;\
      <br>(4)将结果中尾部的“=”号全部去除; \
      <br><br><font color="#FF0000">如果我发现处理出来的上面处理的结果不符合我的要求怎么办？</font>\
      <br>OSS图片服务，支持用管道来支持用户的操作合并。可以将多个操作通过 | 进行合并。 如操作中的简单处理和水印。可以发现中间有一个 |,\
      表示先做简单处理，再做水印，当然你也可以是两个简单处理用管道合并，两种水印进行管道合并。\
      但是如果发现用管道的操作不能满足条件，就要向官方提需求了。他们响应很快的。\
      <br><br><font color="#FF0000">如果我发现文字水印里面的颜色太少了，没有我想要的颜色怎么办？</font>\
      <br>可以通过在颜色的方框里填入颜色的内容，只要满足颜色的格式即可。\
      <br><br><font color="#FF0000">如果发现字体类型太少了，怎么办？</font>\
      <br>OSS图片服务官方只支持这么多字体，只能使用上述字体。可以向官方提需求。\
      <br><br><font color="#FF0000">什么是绝对质量和相对质量？</font>\
      <br>只能在jpeg格式使用。\
      <br>相对质量的定义。决定 jpg 图片的相对 quality,如果原图 quality 是 100%,\
      使用90q会得到 quality90%的图片;如果原图 quality 是 80%,使用“90q”会得到 quality72%的图片\
      绝对质量：决定 jpg 图片的绝对 quality,如果原图 quality 小于指定数字,则不压缩。如果原图 quality 是 100%,使用90Q会得到 quality 90%的图片;\
      如果原图 quality 是 95%,使用 90Q 还会得到 quality如果原图 quality 是 80%,使用 90Q 不会压缩\
      <br><br><font color="#FF0000">什么是适应方向？</font>\
      <br>手机，相机拍出来的照片有时候会有旋转，这个jpeg exif 信息里的rotate参数决定，适应方向就是根据这个参数对图片进行自旋转方向。\
      <br><br><font color="#FF0000">什么是短边和长边？</font>\
      <br>关于 长边 和 短边 的定义需要特别注意,它们表达的是在缩放中相对比例的长\
      或短。长边 是指原尺寸与目标尺寸的比值大的那条边; “短边”同理。如原图 400x200,缩放为 800x100,\
      (400/800=0.5,200/100=2,0.5<2)所以在这个缩放中 200 那条是长边,400 是短边。\
      <br><br><font color="#FF0000">这个工具能保存成样式吗？</font>\
      <br>样式是 OSS图片服务设置的对处理处理的别名，用户可阅读性强，这个工具没有办法直接保存成样式，\
      但是你可以通过OSS图片服务控制台导出样式功能, 导出到文件里，然后把上述生成的操作，把@后面的字符串，覆盖到原来文件里，\
      修改一下样式的名字，然后再用导入样式功能，就能保存到样式了。\
      <br><br><font color="#FF0000">为什么这个工具出现乱码？</font> \
      <br>有可能是浏览器的问题，因为时间有限，测试不了那么多浏览器。但是保证在chrome是运行ok的。'

var g_example_str ='\
      <br>当你辛辛苦苦弄好一张图片时，你不想原图被别人访问。。。。\
      <br>当你为了制作权，在图片上打上属于自己的Logo时 \
      <br>可以别人通过修改参数，轻松绕过，偷取你的作品，并且打上他的水印，占为已有\
      <br>这时，你可能会想要是能阻止这件事发生，多好啊! \
      <br>如果你有这方面的需求，那么开通OSS图片服务吧! \
      <br>我们提供可以提供禁止原图访问，只允许用样式访问。完美解决上述问题 \
      <br>打开禁止原图，别人再也取不到原图了！ \
      <br>你可以把你的logo放在样式里面，然后设置只允许样式访问。这样别人通过其他参数来取到原图了! \
      <br>那么问题来了，应该怎么样设置呢？\
      <br>请参考这篇文章，上面有例子：<a href="http://bbs.aliyun.com/read/230502.html?spm=5176.7189909.0.0.I26w0X">请参考这里</a>'

var g_open_str ='\
      <br><font color="#FF0000">1.我要怎么样开通图片服务？</font>\
      <br>如果你有一个域名www.abc.com 然后你希望用把这个域名下面的所有图片放在OSS,并希望用IMG处理你所使用的图片，你可以选择一个二级域名进行开通，如img.abc.com.\
      <br>在这里需要注意一点，千万不要使用在OSS控制台绑定过的CNAME域名进行开通IMG服务。如果img.abc.com已经绑定过OSS，那么就改用img2.abc.com或者其他域名，进行图片服务开通\
      <br>然后用这个域名在控制台上进行绑定。具体可以参数OSS图片服务官方文档：http://imgs-storage.cdn.aliyuncs.com/help/oss/图片服务帮助文件.pdf \
      <br><br><font color="#FF0000">2.如果控制台提示我绑定成功，接下来我应该怎么做？</font>\
      <br>如果控制台提示绑定成功后，会显示三个域名，如img.abc.com, img.abc.com.alikunlun.com mybucket.img.aliyuncs.com （类似的拼写，上面三个域名只是例子）如果你想使用CDN服务\
      <br>，那么将你的域名img.abc.com 域名解析指向img.abc.com.alikunlun.com, 如果不想使用CDN，那么直接将你的域名img.abc.com 指向mybucket.img.aliyuncs.com\
      <br>OSS图片服务是为了更好服务用户对图片的处理需求。而产生的。开通图片服务，必须使用用户自己的域名\
      <br><br><font color="#FF0000">3.OSS图片服务跟OSS有什么关系？</font>\
      <br>OSS图片服务是为了更好服务用户对图片的处理需求。而产生的。开通图片服务必须使用用户自己的域名，跟OSS的区别就是，IMG不提供上传接口，如果想上传图片，那么请调用 OSS的接口\
      <br>而且OSS支持三级域名直接访问，如您的bucket叫 mybucket(地域是杭州）. 那么你可以通过mybucet.oss-cn-hangzhou.aliyuncs.com, 但是您无法通过mybucket.img-cn-hangzhou.aliyuncs.com进行访问你必须按照1提供的步骤进行图片服务绑定'

var g_problem_str ='\
      <br><font color="#FF0000">1.为什么IMG处理过的图片是旋转，但是原图在浏览器是正常的？</font>\
      <br>JPG图片里面有一个exif信息，这个信息里面有一个Oriention 参数，这个参数指定了图片的旋转参数，如你拍照时，相机是否倒着拍。但是现在一般浏览器都会自动根据这个参数对图片进行自适应参数旋转，导致你看到的图是正常的\
      <br>你可以通过指定infoexif 参数进行查看，获取是否指定了旋转参数。如果你在缩略时，不指定自适应方向时，那么缩略后的图就是按照图片本来的方向，所以你跟浏览器（或者软件）看到图比较，就好像处理后的图是旋转的。这里只要指定\
      <br>自适应方向参数就好了。参数是1o或者2o \
      <br><font color="#FF0000">2.1o,2o参数有什么区别？</font>\
      <br>没有缩略的情况下，两者是一样的。如果有缩略，那么1o就是先缩略后旋转。2o就是先缩略后缩略。\
      <br>如果你想到获取100w_200h的图片，1o参数得到的图有可能是200w_100h， 因为是先缩略成100w_200h. 再旋转 \
      <br>如果是就想得到100w_200h 这个大小， 那么请使用2o参数。因为2o参数，就是先旋转后缩略。\
      <br><font color="#FF0000">3.如果我的图片是没有旋转参数时，指定1o,2o会不会让我的图片旋转？</font>\
      <br>不会。1o,2o只会根据jpg exif 里面的Oriention参数进行旋转，如果没有这个参数，就1o, 2o不做任何事，如果这里你想让图片旋转，请使用r参数\
      <br>在这里需要注意一点，千万不要使用在OSS控制台绑定过的CNAME域名进行开通IMG服务。如果img.abc.com已经绑定过OSS，那么就改用img2.abc.com或者其他域名，进行图片服务开通 '
