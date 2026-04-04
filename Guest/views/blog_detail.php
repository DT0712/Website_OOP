<?php 
$current_page = basename($_SERVER['PHP_SELF']);
include "../includes/header.php";

$posts = [
    1 => [
    'title'   => 'Top xe đạp bán chạy tháng',
    'tag'     => 'NEW',
    'image'   => '../assets/images/biketop.jpg',
    'date'    => 'Admin · 01/04/2026',
    'content' => '
        <p>Trong thời gian gần đây, xe đạp không chỉ còn là phương tiện di chuyển đơn thuần mà còn trở thành một phần trong lối sống của nhiều người – từ đi học, đi làm cho đến rèn luyện sức khỏe. 
        Tuy nhiên, giữa rất nhiều lựa chọn trên thị trường, việc tìm được một chiếc xe “đáng tiền” lại không hề dễ dàng.</p>

        <p>Hiểu được điều đó, mình đã tổng hợp 3 mẫu xe đạp bán chạy nhất trong tháng – không chỉ vì thương hiệu mà còn vì trải nghiệm thực tế mà chúng mang lại. 
        Nếu bạn đang chuẩn bị “xuống tiền”, đây sẽ là những lựa chọn đáng để cân nhắc.</p>

        <h5> 1. Giant Escape 3 – Lựa chọn an toàn cho người mới bắt đầu</h5>
        <p>Giant Escape 3 là mẫu xe gần như luôn nằm trong top bán chạy bởi sự cân bằng rất tốt giữa giá thành và trải nghiệm. 
        Ngay từ lần đầu sử dụng, bạn sẽ cảm nhận được sự nhẹ nhàng khi đạp, xe lướt khá nhanh trên đường phố và không gây cảm giác mệt khi đi quãng đường dài.</p>

        <p>Điểm đáng giá nhất của Escape 3 nằm ở sự đơn giản nhưng hiệu quả: khung nhôm nhẹ, thiết kế tối ưu cho tư thế ngồi thoải mái và khả năng vận hành ổn định. 
        Đây là kiểu xe mà bạn có thể sử dụng mỗi ngày mà không cần suy nghĩ quá nhiều.</p>

        <p><b>Vì sao nên chọn?</b> Nếu bạn là sinh viên hoặc người mới tập đi xe, đây là khoản đầu tư “an toàn” – không quá đắt nhưng dùng lâu dài và ít hỏng vặt.</p>
        <img src="../assets/images/giant-escape-3-1.jpg" style="width:100%; border-radius:10px; margin:10px 0;">

        <h5> 2. Trek Marlin 7 – Mạnh mẽ, đa dụng và đáng tin cậy</h5>
        <p>Khác với Escape 3, Trek Marlin 7 hướng đến những người cần một chiếc xe “làm được nhiều hơn”. 
        Dù là đường phố, đường xấu hay những chuyến đi xa, chiếc xe này đều mang lại cảm giác chắc chắn và ổn định.</p>

        <p>Phuộc trước giúp giảm xóc tốt, đặc biệt khi đi qua những đoạn đường gồ ghề. 
        Khung xe cứng cáp tạo cảm giác an tâm khi chạy tốc độ cao hoặc leo dốc. 
        Đây là dòng xe bạn có thể tin tưởng khi cần một người bạn đồng hành lâu dài.</p>

        <p><b>Vì sao nên chọn?</b> Nếu bạn không muốn bị giới hạn bởi địa hình và thích một chiếc xe “đi đâu cũng được”, thì Marlin 7 hoàn toàn xứng đáng với số tiền bỏ ra.</p>
        <img src="../assets/images/trek-marlin-7-2.jpg" style="width:100%; border-radius:10px; margin:10px 0;">

        <h5> 3. Twitter Thunder Carbon – Trải nghiệm cao cấp cho người thích tốc độ</h5>
        <p>Twitter Thunder Carbon là lựa chọn dành cho những ai muốn nâng tầm trải nghiệm. 
        Điểm khác biệt lớn nhất nằm ở khung carbon siêu nhẹ – giúp xe tăng tốc nhanh hơn và mang lại cảm giác “lướt” rất rõ rệt so với các dòng xe phổ thông.</p>

        <p>Không chỉ nhẹ, thiết kế của xe cũng mang đậm chất thể thao và hiện đại, phù hợp với những người thích sự nổi bật. 
        Khi đã quen với dòng xe này, bạn sẽ khó quay lại những mẫu xe cơ bản hơn.</p>

        <p><b>Vì sao nên chọn?</b> Nếu bạn sẵn sàng đầu tư để có trải nghiệm tốt hơn, tốc độ hơn và cảm giác lái “đã” hơn, thì đây là lựa chọn rất đáng tiền.</p>
        <img src="../assets/images/twitter-thunder-carbon-3.jpg" style="width:100%; border-radius:10px; margin:10px 0;">

        <h5> Đây là những mẫu xe bán chạy nhất tháng. Đâu là lựa chọn dành cho bạn?</h5>
        <p>Mỗi chiếc xe trong danh sách này đều hướng đến một nhóm người dùng khác nhau. 
        Nếu bạn cần sự đơn giản và tiết kiệm, Giant Escape 3 là đủ. 
        Nếu bạn muốn một chiếc xe bền bỉ, đa dụng, Trek Marlin 7 sẽ không làm bạn thất vọng. 
        Và nếu bạn đang tìm kiếm cảm giác mới mẻ, tốc độ và đẳng cấp hơn, Twitter Thunder Carbon là lựa chọn đáng để đầu tư.</p>

        <p> Lời khuyên thật: hãy chọn chiếc xe phù hợp với nhu cầu hiện tại của bạn. 
        Một lựa chọn đúng ngay từ đầu sẽ giúp bạn sử dụng lâu dài và cảm thấy “đáng tiền” hơn rất nhiều.</p>
    '
],

    2 => [
    'title'   => 'Cách chọn xe đạp phù hợp',
    'tag'     => 'TIPS',
    'image'   => '../assets/images/biketip.jpg',
    'date'    => 'Admin · 01/04/2026',
    'content' => '
        <p>Việc chọn một chiếc xe đạp phù hợp không đơn giản chỉ là nhìn vào giá hay mẫu mã. 
        Một chiếc xe tốt là chiếc xe phù hợp với nhu cầu sử dụng, thể trạng và thói quen di chuyển của bạn. 
        Nếu chọn sai, bạn có thể sẽ cảm thấy khó chịu khi sử dụng hoặc nhanh chóng muốn đổi xe chỉ sau một thời gian ngắn.</p>

        <p>Dưới đây là những yếu tố quan trọng bạn nên cân nhắc trước khi quyết định mua xe, giúp bạn tránh lãng phí và chọn được chiếc xe thực sự “đáng tiền”.</p>

        <h5> 1. Xác định rõ mục đích sử dụng</h5>
        <p>Đây là yếu tố quan trọng nhất. Mỗi loại xe được thiết kế cho một mục đích riêng, nếu chọn đúng ngay từ đầu, bạn sẽ có trải nghiệm tốt hơn rất nhiều.</p>

        <p>• <b>Đi học, đi làm, di chuyển trong thành phố:</b> nên chọn xe hybrid hoặc city bike vì nhẹ, dễ điều khiển và tiết kiệm sức.</p>
        <p>• <b>Đường xấu, địa hình, đi phượt:</b> nên chọn mountain bike (MTB) để có độ bền và khả năng giảm xóc tốt.</p>
        <p>• <b>Tốc độ, tập luyện thể thao:</b> road bike hoặc xe khung carbon sẽ giúp bạn đạp nhanh và hiệu quả hơn.</p>

        <p><b>Lời khuyên:</b> Đừng cố chọn xe “đa năng” nếu bạn đã biết rõ nhu cầu chính của mình. Chọn đúng mục đích sẽ giúp bạn hài lòng lâu dài hơn.</p>

        <h5> 2. Chọn đúng size khung – yếu tố nhiều người bỏ qua</h5>
        <p>Một chiếc xe dù tốt đến đâu nhưng sai size vẫn sẽ gây khó chịu khi sử dụng. 
        Bạn có thể bị đau lưng, mỏi vai hoặc khó kiểm soát xe nếu khung không phù hợp.</p>

        <p>• Người cao <b>160 – 170cm</b>: nên chọn size S hoặc M</p>
        <p>• Người cao <b>170 – 180cm</b>: nên chọn size M hoặc L</p>
        <p>• Trên <b>180cm</b>: nên chọn size L hoặc XL</p>

        <p><b>Mẹo nhỏ:</b> Khi ngồi lên xe, bạn nên cảm thấy thoải mái, không bị với tay quá xa hoặc gập người quá nhiều.</p>

        <h5> 3. Xác định ngân sách hợp lý</h5>
        <p>Không phải cứ xe đắt là tốt nhất. Điều quan trọng là chiếc xe có phù hợp với nhu cầu của bạn hay không.</p>

        <p>• Tầm <b>5 – 10 triệu</b>: phù hợp cho nhu cầu cơ bản, đi lại hằng ngày</p>
        <p>• Tầm <b>10 – 20 triệu</b>: chất lượng tốt hơn, đa dụng hơn</p>
        <p>• Trên <b>20 triệu</b>: dành cho trải nghiệm cao cấp hoặc tập luyện chuyên sâu</p>

        <p><b>Lời khuyên:</b> Nếu bạn là người mới, không cần thiết phải đầu tư quá nhiều ngay từ đầu. 
        Một chiếc xe tầm trung là đủ để bạn làm quen và sử dụng lâu dài.</p>

        <h5> 4. Kiểm tra kỹ nếu mua xe cũ</h5>
        <p>Xe cũ có thể giúp bạn tiết kiệm chi phí, nhưng cũng tiềm ẩn nhiều rủi ro nếu không kiểm tra kỹ.</p>

        <p>• Kiểm tra <b>khung xe</b>: không bị nứt, cong</p>
        <p>• Kiểm tra <b>phanh</b>: hoạt động tốt, không bị bó</p>
        <p>• Kiểm tra <b>xích, líp</b>: không bị mòn quá nhiều</p>

        <p><b>Lưu ý:</b> Nếu bạn không có kinh nghiệm, nên đi cùng người có hiểu biết hoặc chọn mua ở cửa hàng uy tín.</p>

        <h5> Tổng kết</h5>
        <p>Chọn xe đạp không khó, quan trọng là bạn hiểu rõ nhu cầu của mình. 
        Hãy bắt đầu từ mục đích sử dụng, chọn đúng size, cân nhắc ngân sách và kiểm tra kỹ trước khi mua.</p>

        <p>👉 Một chiếc xe phù hợp sẽ không chỉ giúp bạn di chuyển dễ dàng hơn mà còn tạo động lực để bạn duy trì thói quen đạp xe mỗi ngày. 
        Và đó mới là giá trị thực sự của một chiếc xe tốt.</p>
    '
],

  3 => [
    'title'   => 'Hành trình đạp xe đáng nhớ',
    'tag'     => 'TRAVEL',
    'image'   => '../assets/images/biketravel.jpg',
    'date'    => 'Admin · 01/04/2026',
    'content' => '
        <p>Đạp xe không chỉ đơn giản là một môn thể thao, mà còn là cách để bạn cảm nhận thế giới theo một nhịp độ rất khác – chậm hơn, gần gũi hơn và chân thật hơn. 
        Không có cửa kính ngăn cách, không có tiếng động cơ ồn ào, chỉ có bạn, chiếc xe và những cung đường phía trước.</p>

        <p>Trong bài viết này, mình muốn chia sẻ một vài hành trình đạp xe đáng nhớ mà bất cứ ai yêu thích xe đạp cũng nên thử ít nhất một lần. 
        Mỗi nơi mang một cảm xúc riêng, nhưng điểm chung là đều để lại những trải nghiệm rất khó quên.</p>

        <h5> Cung đường Đà Lạt – Mát mẻ và đầy cảm hứng</h5>
        <p>Đà Lạt luôn là điểm đến lý tưởng cho những chuyến đạp xe nhờ khí hậu dễ chịu quanh năm. 
        Một trong những cung đường đẹp nhất là từ trung tâm thành phố đến hồ Tuyền Lâm, dài khoảng 8km.</p>

        <p>Trên đường đi, bạn sẽ cảm nhận rõ không khí se lạnh, những hàng thông xanh và khung cảnh yên bình rất đặc trưng của Đà Lạt. 
        Đây không phải là cung đường quá khó, nhưng đủ để bạn vừa vận động, vừa tận hưởng thiên nhiên.</p>

        <p><b>Cảm nhận:</b> Nhẹ nhàng, thư giãn, cực kỳ phù hợp cho những chuyến đi “reset” lại bản thân.</p>

        <h5> Ven biển Mũi Né – Tự do và khoáng đạt</h5>
        <p>Nếu bạn thích cảm giác gió biển và không gian rộng mở, thì Mũi Né là lựa chọn không thể bỏ qua. 
        Đạp xe vào buổi sáng sớm, khi nắng còn nhẹ và đường còn vắng, là thời điểm lý tưởng nhất.</p>

        <p>Con đường ven biển dài, thoáng, một bên là biển xanh, một bên là đồi cát tạo nên khung cảnh rất đặc biệt. 
        Cảm giác vừa đạp xe vừa nghe tiếng sóng biển thực sự rất “đã”.</p>

        <p><b>Cảm nhận:</b> Tự do, thoải mái, rất phù hợp cho những ai muốn trải nghiệm cảm giác “đi thật xa”.</p>

        <h5> Phố cổ Hội An – Chậm rãi và đầy hoài niệm</h5>
        <p>Hội An có thể xem là “thiên đường xe đạp” với nhịp sống chậm và không gian yên bình. 
        Việc đạp xe quanh phố cổ, len lỏi qua từng con hẻm nhỏ mang lại một trải nghiệm rất khác so với các phương tiện khác.</p>

        <p>Bạn có thể dừng lại bất cứ lúc nào để uống cà phê, chụp ảnh hoặc đơn giản là ngồi nhìn dòng người qua lại. 
        Đây là kiểu hành trình không cần vội vàng, chỉ cần tận hưởng.</p>

        <p><b>Cảm nhận:</b> Nhẹ nhàng, sâu lắng, phù hợp để “sống chậm” và tận hưởng từng khoảnh khắc.</p>

        <h5> Tổng kết</h5>
        <p>Mỗi hành trình đạp xe đều mang lại một trải nghiệm khác nhau, từ nhẹ nhàng ở Đà Lạt, phóng khoáng ở Mũi Né cho đến yên bình tại Hội An. 
        Điều quan trọng không phải là bạn đi xa bao nhiêu, mà là bạn cảm nhận được gì trên từng vòng quay của bánh xe.</p>

        <p> Nếu có cơ hội, hãy thử một chuyến đi như vậy. 
        Chỉ cần một chiếc xe phù hợp, một chút thời gian và tinh thần sẵn sàng khám phá, bạn sẽ có những kỷ niệm mà không chuyến đi nào khác mang lại được.</p>
    '
],

4 => [
    'title'   => 'Xe đạp thể thao cho người mới',
    'tag'     => 'NEWBIE',
    'image'   => '../assets/images/bikenewbie.jpg',
    'date'    => 'Admin · 01/04/2026',
    'content' => '
        <p>Nếu bạn đang muốn bắt đầu với xe đạp thể thao nhưng chưa biết nên chọn loại nào, bắt đầu từ đâu hay cần chuẩn bị những gì, thì bạn không hề đơn độc. 
        Rất nhiều người cũng từng ở vị trí giống bạn – và tin tốt là: bắt đầu đạp xe dễ hơn bạn nghĩ rất nhiều.</p>

        <p>Quan trọng nhất không phải là mua một chiếc xe thật đắt tiền, mà là chọn đúng loại phù hợp với nhu cầu và tạo được thói quen sử dụng lâu dài.</p>

        <h5>🚲 1. Người mới nên bắt đầu với loại xe nào?</h5>
        <p>Đối với người mới, bạn không cần những dòng xe quá chuyên sâu hay cấu hình cao. 
        Thay vào đó, hãy ưu tiên những dòng xe dễ sử dụng, tư thế ngồi thoải mái và phù hợp với đường phố Việt Nam.</p>

        <p><b>Gợi ý:</b></p>
        <ul>
            <li><b>Hybrid bike (xe lai):</b> Kết hợp giữa tốc độ và sự thoải mái, phù hợp đi học, đi làm và tập thể dục.</li>
            <li><b>City bike:</b> Thiết kế đơn giản, dễ điều khiển, rất phù hợp cho nhu cầu di chuyển hằng ngày.</li>
        </ul>

        <p> Đây là những lựa chọn “an toàn” giúp bạn làm quen với việc đạp xe mà không bị quá sức hay khó điều khiển.</p>

        <h5> 2. Chọn size xe – yếu tố nhiều người bỏ qua</h5>
        <p>Một chiếc xe phù hợp kích thước sẽ giúp bạn đạp thoải mái hơn, tránh đau lưng và hạn chế chấn thương.</p>

        <ul>
            <li>Chiều cao 150–165cm → Size S</li>
            <li>Chiều cao 165–175cm → Size M</li>
            <li>Chiều cao 175–185cm → Size L</li>
        </ul>

        <p> Nếu có thể, hãy thử ngồi lên xe trước khi mua để cảm nhận rõ nhất.</p>

        <h5> 3. Những trang bị cần thiết khi bắt đầu</h5>
        <p>Đạp xe an toàn quan trọng hơn bất kỳ yếu tố nào khác. 
        Dưới đây là những món cơ bản bạn nên chuẩn bị:</p>

        <ul>
            <li><b>Mũ bảo hiểm:</b> Bắt buộc – bảo vệ bạn trong mọi tình huống.</li>
            <li><b>Găng tay:</b> Giảm đau tay khi đạp lâu.</li>
            <li><b>Kính:</b> Chống bụi, côn trùng và ánh nắng.</li>
            <li><b>Bơm mini / bộ vá lốp:</b> Phòng trường hợp xe bị xẹp giữa đường.</li>
        </ul>

        <p> Không cần mua tất cả ngay từ đầu, nhưng mũ bảo hiểm là thứ bạn không nên bỏ qua.</p>

        <h5> 4. Bắt đầu luyện tập như thế nào?</h5>
        <p>Đừng cố gắng đạp quá xa ngay từ ngày đầu tiên. 
        Điều quan trọng là tạo thói quen và để cơ thể thích nghi dần.</p>

        <ul>
            <li>Tuần đầu: 5–10km / ngày</li>
            <li>Tuần 2–3: tăng lên 10–15km</li>
            <li>Sau 1 tháng: có thể thử 20km trở lên</li>
        </ul>

        <p>Hãy giữ tốc độ vừa phải, tập trung vào cảm giác thoải mái thay vì cố gắng đi nhanh.</p>

        <h5> 5. Một vài lời khuyên cho người mới</h5>
        <ul>
            <li>Không cần mua xe quá đắt ngay từ đầu</li>
            <li>Ưu tiên sự thoải mái hơn tốc độ</li>
            <li>Đạp đều đặn quan trọng hơn đạp xa</li>
            <li>Bảo dưỡng xe định kỳ để xe luôn vận hành tốt</li>
        </ul>

        <p>Bắt đầu với xe đạp thể thao không hề khó. 
        Chỉ cần một chiếc xe phù hợp, một chút kiên trì và thói quen luyện tập, bạn sẽ nhanh chóng cảm nhận được lợi ích cả về sức khỏe lẫn tinh thần.</p>

        <p> Đừng chờ “chuẩn bị hoàn hảo” mới bắt đầu. 
        Chỉ cần có xe – bạn đã sẵn sàng cho hành trình của mình rồi.</p>
    '
],
    5 => [
    'title'   => 'Kinh nghiệm bảo dưỡng xe',
    'tag'     => 'TIPS',
    'image'   => '../assets/images/bikefix.jpg',
    'date'    => 'Admin · 01/04/2026',
    'content' => '
        <p>Một chiếc xe đạp dù tốt đến đâu cũng sẽ xuống cấp theo thời gian nếu không được bảo dưỡng đúng cách. 
        Việc chăm sóc xe định kỳ không chỉ giúp xe vận hành mượt mà hơn mà còn tiết kiệm chi phí sửa chữa về lâu dài và đảm bảo an toàn cho bạn trên mọi hành trình.</p>

        <p>Điều quan trọng là bạn không cần phải là thợ chuyên nghiệp – chỉ cần nắm một vài nguyên tắc cơ bản, bạn hoàn toàn có thể tự bảo dưỡng chiếc xe của mình tại nhà.</p>

        <h5> 1. Vệ sinh xích và líp – việc nhỏ nhưng cực kỳ quan trọng</h5>
        <p>Xích là bộ phận hoạt động liên tục và dễ bám bụi bẩn nhất. Nếu không vệ sinh thường xuyên, xích sẽ nhanh mòn, gây tiếng ồn và làm việc chuyển số trở nên kém mượt.</p>

        <ul>
            <li>Lau xích bằng khăn khô sau khi đi mưa hoặc đường bụi</li>
            <li>Tra dầu chuyên dụng mỗi 2–3 tuần</li>
            <li>Tránh dùng dầu nhớt xe máy vì dễ bám bụi</li>
        </ul>

        <p> Một sợi xích sạch sẽ giúp xe chạy nhẹ hơn rõ rệt.</p>

        <h5> 2. Kiểm tra phanh – yếu tố an toàn hàng đầu</h5>
        <p>Phanh là bộ phận bạn không nên “để ý khi có vấn đề”, mà cần kiểm tra thường xuyên ngay cả khi xe vẫn chạy bình thường.</p>

        <ul>
            <li>Bóp thử phanh trước mỗi chuyến đi</li>
            <li>Nếu phanh bị lỏng hoặc ăn chậm → cần chỉnh lại dây</li>
            <li>Má phanh mòn quá 50% → nên thay ngay</li>
        </ul>

        <p> Một hệ thống phanh tốt có thể giúp bạn tránh được những tình huống nguy hiểm bất ngờ.</p>

        <h5> 3. Bơm lốp đúng áp suất – đạp nhẹ hơn, đi xa hơn</h5>
        <p>Nhiều người thường bỏ qua việc kiểm tra áp suất lốp, nhưng đây lại là yếu tố ảnh hưởng trực tiếp đến trải nghiệm đạp xe.</p>

        <ul>
            <li>Lốp xe đường phố: khoảng 80–100 PSI</li>
            <li>Lốp địa hình: thấp hơn để tăng độ bám</li>
            <li>Kiểm tra lốp mỗi tuần để tránh xẹp bất ngờ</li>
        </ul>

        <p> Lốp đủ hơi giúp giảm ma sát, tiết kiệm sức và hạn chế hỏng săm.</p>

        <h5> 4. Kiểm tra ốc vít và khung xe</h5>
        <p>Sau một thời gian sử dụng, các ốc vít trên xe có thể bị lỏng do rung lắc. 
        Điều này có thể gây ra tiếng kêu khó chịu hoặc thậm chí mất an toàn khi di chuyển.</p>

        <ul>
            <li>Kiểm tra định kỳ các vị trí như cổ lái, yên xe, bánh xe</li>
            <li>Siết chặt lại nếu phát hiện lỏng</li>
            <li>Quan sát khung xe để phát hiện nứt hoặc cong bất thường</li>
        </ul>

        <h5> 5. Giữ xe luôn sạch sẽ</h5>
        <p>Một chiếc xe sạch không chỉ đẹp hơn mà còn giúp bạn dễ dàng phát hiện các vấn đề sớm hơn.</p>

        <ul>
            <li>Rửa xe nhẹ nhàng bằng nước và khăn mềm</li>
            <li>Tránh xịt nước áp lực mạnh vào ổ trục</li>
            <li>Lau khô sau khi rửa để tránh rỉ sét</li>
        </ul>

        <h5> Một vài lưu ý nhỏ nhưng hữu ích</h5>
        <ul>
            <li>Nếu không tự tin sửa chữa, hãy mang xe ra tiệm định kỳ 2–3 tháng/lần</li>
            <li>Luôn mang theo bộ dụng cụ cơ bản khi đi xa</li>
            <li>Nghe tiếng xe – nếu có âm thanh lạ, đó là dấu hiệu cần kiểm tra</li>
        </ul>

        <p>Chăm sóc xe đạp không hề phức tạp, nhưng lại mang đến sự khác biệt rất lớn trong trải nghiệm sử dụng. 
        Một chiếc xe được bảo dưỡng tốt sẽ luôn mang lại cảm giác êm ái, nhẹ nhàng và đáng tin cậy trên mọi cung đường.</p>

        <p> Hãy dành một chút thời gian cho chiếc xe của bạn – nó sẽ “đáp lại” bằng những hành trình mượt mà hơn rất nhiều.</p>
    '
],

];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$post = $posts[$id] ?? $posts[1];
?>

<div class="container mt-4 mb-5" style="max-width: 800px;">

    <!-- Breadcrumb -->
    <nav style="font-size:13px; color:#999; margin-bottom:20px;">
        <a href="blog.php" style="color:#e60000; text-decoration:none;">← Quay lại Blog</a>
    </nav>

    <!-- Tag -->
    <span style="background:#00bcd4; color:white; padding:4px 12px; 
                 border-radius:20px; font-size:12px; font-weight:bold;">
        <?= $post['tag'] ?>
    </span>

    <!-- Tiêu đề -->
    <h2 style="margin-top:15px; font-weight:700;">
        <?= $post['title'] ?>
    </h2>

    <!-- Tác giả -->
    <small class="text-muted">By <?= $post['date'] ?></small>

    <!-- Ảnh chính -->
    <img src="<?= $post['image'] ?>" 
         style="width:100%; height:400px; object-fit:cover; 
                border-radius:15px; margin:20px 0;">

    <!-- Nội dung -->
    <div style="font-size:15px; line-height:1.8; color:#333;">
        <?= $post['content'] ?>
    </div>

    <!-- Divider -->
    <hr style="margin:40px 0;">

    <!-- Bài viết liên quan -->
    <h5 style="font-weight:700; margin-bottom:20px;">Bài viết liên quan</h5>
    <div class="row">
        <?php foreach($posts as $pid => $p): ?>
            <?php if($pid != $id): ?>
            <div class="col-md-6 mb-3">
                <a href="blog_detail.php?id=<?= $pid ?>" 
                   style="text-decoration:none; color:inherit;">
                    <div class="post-card">
                        <img src="<?= $p['image'] ?>" 
                             style="width:100%; height:160px; 
                                    object-fit:cover; border-radius:10px;">
                        <h6 style="margin-top:8px; font-weight:600;">
                            <?= $p['title'] ?>
                        </h6>
                        <small class="text-muted">By <?= $p['date'] ?></small>
                    </div>
                </a>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>

<?php include "../includes/footer.php"; ?>
</body>
</html>