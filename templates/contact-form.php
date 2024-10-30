<form id="katisoft-testimonial-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">

	<div class="field-container form-group">
		<input type="text" class="field-input form-control" placeholder="Họ và tên" id="name" name="name" required>
		<small class="field-msg error" data-error="invalidName">Họ và tên là bắt buộc</small>
	</div>

	<div class="field-container form-group">
		<input type="email" class="field-input form-control" placeholder="Địa chỉ E-mail" id="email" name="email" required>
		<small class="field-msg error" data-error="invalidEmail">E-mail không đúng định dạng</small>
	</div>

	<div class="field-container form-group">
		<textarea name="message" id="message" class="field-input form-control" placeholder="Nội dung tin nhắn" rows="5" required></textarea>
		<small class="field-msg error" data-error="invalidMessage">Nội dung là bắt buộc</small>
	</div>
	
	<div class="field-container">
		<div>
            <button type="submit" class="btn btn-success btn-md btn-sunset-form">Gửi thư</button>
        </div>
		<small class="field-msg js-form-submission">Đang gửi tin nhắn, vui lòng chờ&hellip;</small>
		<small class="field-msg success js-form-success">Tin nhắn đã được gửi, cảm ơn bạn!</small>
		<small class="field-msg error js-form-error">Có một vấn đề khi gửi tin nhắn, vui lòng thử lại!</small>
	</div>

	<input type="hidden" name="action" value="submit_testimonial">
	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("testimonial-nonce") ?>">

</form>