# Sửa Lỗi Tạo Nhân Vật

## Vấn đề đã được sửa

Đã sửa lỗi khi tạo nhân vật xong bị quay về trang index, không tạo được nhân vật.

## Các lỗi đã sửa:

1. **Lỗi command không khớp**: Form trong `TaoNhanVat.php` sử dụng `cmd=cjplayer` (tên cũ) nhưng `game.php` chỉ xử lý `create_player` (tên mới)
   - **Sửa**: Đổi `cmd=cjplayer` thành `cmd=create_player` trong form

2. **Lỗi biến chưa khởi tạo**: Biến `$player` chưa được khởi tạo trước khi sử dụng `$player->sid`
   - **Sửa**: Tạo biến `$existingSid` để kiểm tra

3. **Lỗi thiếu xử lý khi người chơi đã có nhân vật**: Khi người chơi đã có nhân vật, code `exit()` mà không redirect
   - **Sửa**: Thêm logic chuyển hướng đến trang game khi người chơi đã có nhân vật

4. **Lỗi thiếu giá trị mặc định**: Biến `$shenfen` có thể không được set từ form
   - **Sửa**: Thêm kiểm tra và set giá trị mặc định = 1 (Chiến sĩ)

5. **Lỗi database thiếu cột**: Cột `shenfen` chưa tồn tại trong bảng `game1`
   - **Sửa**: Thêm try-catch để xử lý cả 2 trường hợp (có hoặc không có cột `shenfen`)

## Cách cập nhật database (Khuyến nghị)

Để sử dụng đầy đủ tính năng thân phận (Chiến sĩ, Hiệp sĩ, Ẩn sĩ), chạy file SQL sau:

```bash
mysql -u username -p database_name < update_shenfen.sql
```

Hoặc import file `update_shenfen.sql` qua phpMyAdmin.

## Kiểm tra

1. Đăng nhập vào game
2. Tạo nhân vật mới
3. Nhân vật sẽ được tạo thành công và tự động chuyển vào game
4. Không còn bị quay về trang index

## Các file đã sửa

- `src/Game/TaoNhanVat.php` - Sửa command trong form
- `game.php` - Sửa logic tạo nhân vật, xử lý lỗi database
- `update_shenfen.sql` - Script SQL để thêm cột shenfen (tùy chọn)
