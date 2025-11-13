# CMD Reference Guide

This document provides a complete reference for all game commands (CMD parameters). All commands have been updated from Chinese pinyin abbreviations to clear English names for better readability and maintainability.

## Command Categories

### Character Management
| Command | Description | File |
|---------|-------------|------|
| `create_character` | Create new character page | TaoNhanVat.php |
| `create_player` | Process character creation | TaoNhanVat.php |
| `character_status` | View character status | TrangThaiNhanVat.php |
| `login` | Player login | (inline in game.php) |

### Combat Commands
| Command | Description | File |
|---------|-------------|------|
| `pve` | Player vs Environment combat | ChienDauQuaiVat.php |
| `pve_attack` | Attack in PVE combat | ChienDauQuaiVat.php |
| `pvp` | Player vs Player combat | ChienDauNguoiChoi.php |
| `boss_battle` | Battle against boss | ChienDauTruongLao.php |
| `boss_attack` | Attack boss | ChienDauTruongLao.php |
| `flee` | Flee from battle | ChienDauTruongLao.php |

### Inventory/Bag Commands
| Command | Description | File |
|---------|-------------|------|
| `get_equipment_bag` | View equipment inventory | TuiTrangBi.php |
| `get_pill_bag` | View pill inventory | TuiDan.php |
| `get_medicine_bag` | View medicine inventory | TuiDuocPham.php |
| `get_skill_bag` | View skill inventory | TuiKyNang.php |
| `get_item_bag` | View item inventory | TuiDaoCu.php |

### Equipment Commands
| Command | Description | File |
|---------|-------------|------|
| `equipment_info` | View equipment details | ThongTinTrangBi.php |
| `view_equipment` | View equipment details | ThongTinTrangBi.php |
| `unequip` | Unequip item | TrangThaiNhanVat.php |
| `set_equipment_position` | Set equipment position | TrangThaiNhanVat.php |
| `delete_equipment` | Delete equipment | TuiTrangBi.php |
| `upgrade_equipment` | Upgrade equipment | ThongTinTrangBi.php |
| `equipment_set` | View equipment sets | BoTrangBi.php |
| `system_equipment_info` | System equipment info | ThongTinTrangBiHeThong.php |

### Cultivation/Training Commands
| Command | Description | File |
|---------|-------------|------|
| `goto_cultivation` | Go to cultivation area | TuLuyen.php |
| `start_cultivation` | Start cultivation | TuLuyen.php |
| `end_cultivation` | End cultivation | TuLuyen.php |
| `martial_arts_training` | Martial arts training | VoKong.php |
| `martial_training` | Martial training | VoKong.php |
| `learn_martial_arts` | Learn martial arts | HocVoKong.php |
| `end_martial_training` | End martial training | VoKong.php |

### Social/Chat Commands
| Command | Description | File |
|---------|-------------|------|
| `chat` | Public chat | TroChuyen.php |
| `send_chat` | Send chat message | TroChuyen.php |
| `private_message` | Private messaging | TinNhanRieng.php |
| `get_player_info` | View other player info | TrangThaiNguoiKhac.php |

### Map/Navigation Commands
| Command | Description | File |
|---------|-------------|------|
| `goto_map` | Go to map location | BanDoHienTai.php |
| `all_maps` | View all maps | TatCaBanDo.php |
| `area_map` | View area map | KhuVucBanDo.php |
| `map` | View map | ditu.html |

### NPC/Shop Commands
| Command | Description | File |
|---------|-------------|------|
| `npc` | Interact with NPC | npc.php |
| `shop` | Open shop | CuaHang.php |
| `exchange` | Exchange items | DoiThuong.php |
| `recharge_gm` | GM recharge | czbgm.php |
| `change_name` | Change character name | gaiming.php |

### Quest Commands
| Command | Description | File |
|---------|-------------|------|
| `quest` | View quests | NhiemVu.php |
| `my_quests` | View my quests | NhiemVuNguoiChoi.php |
| `quest_info` | View quest details | ThongTinNhiemVu.php |

### Information Commands
| Command | Description | File |
|---------|-------------|------|
| `get_game_info` | Get game information | ThongTinTroChoi.php |
| `item_info` | View item details | ThongTinDaoCu.php |
| `skill_info` | View skill details | ThongTinKyNang.php |
| `pill_info` | View pill details | ThongTinThuoc.php |
| `medicine_info` | View medicine details | ThongTinDuocPham.php |
| `boss_info` | View boss details | ThongTinTruongLao.php |

### Other Features
| Command | Description | File |
|---------|-------------|------|
| `pet` | Manage pets | SungVat.php |
| `breakthrough` | Character breakthrough | DotPha.php |
| `arena` | Arena/PvP room | PhongThi.php |
| `guild` | Guild management | BangHoi.php |
| `guild_list` | View guild list | DanhSachBangHoi.php |
| `talent` | Talent system | ThienPhu.php |
| `ranking` | View rankings | BangXepHang.php |

## Migration Guide

If you have any external tools, documentation, or bookmarks using the old Chinese pinyin commands, use this mapping to update them:

### Old → New Command Mapping

**Character:**
- `cj` → `create_character`
- `cjplayer` → `create_player`
- `zhuangtai` → `character_status`

**Combat:**
- `pvegj` → `pve_attack`
- `pvbgj` → `boss_attack`
- `pvb` → `boss_battle`
- `taopao` → `flee`

**Inventory:**
- `getbagzb` → `get_equipment_bag`
- `getbagyp` → `get_pill_bag`
- `getbagyd` → `get_medicine_bag`
- `getbagjn` → `get_skill_bag`
- `getbagdj` → `get_item_bag`

**Equipment:**
- `zbinfo` → `equipment_info`
- `zbinfo_sys` → `system_equipment_info`
- `xxzb` → `unequip`
- `setzbwz` → `set_equipment_position`
- `delezb` → `delete_equipment`
- `upzb` → `upgrade_equipment`
- `chakanzb` → `view_equipment`
- `taozhuang` → `equipment_set`

**Cultivation:**
- `goxiulian` → `goto_cultivation`
- `startxiulian` → `start_cultivation`
- `endxiulian` → `end_cultivation`
- `wgxiulian` → `martial_arts_training`
- `wgxl` → `martial_training`
- `xxwg` → `learn_martial_arts`
- `jswg` → `end_martial_training`

**Social:**
- `liaotian` → `chat`
- `sendliaotian` → `send_chat`
- `im` → `private_message`
- `getplayerinfo` → `get_player_info`

**Navigation:**
- `gomid` → `goto_map`
- `allmap` → `all_maps`
- `qydt` → `area_map`
- `ditu` → `map`

**NPC/Shop:**
- `shangdian` → `shop`
- `duihuan` → `exchange`
- `czbgm` → `recharge_gm`
- `gaiming` → `change_name`

**Quests:**
- `task` → `quest`
- `mytask` → `my_quests`
- `mytaskinfo` → `quest_info`

**Information:**
- `getginfo` → `get_game_info`
- `djinfo` → `item_info`
- `jninfo` → `skill_info`
- `ypinfo` → `pill_info`
- `ydinfo` → `medicine_info`
- `boss` → `boss_info`

**Other:**
- `chongwu` → `pet`
- `tupo` → `breakthrough`
- `fangshi` → `arena`
- `club` → `guild`
- `clublist` → `guild_list`
- `tianfu` → `talent`
- `paihang` → `ranking`

## Usage Examples

### Before (Old Chinese Pinyin):
```php
// Go to map
$cmd = $encode->encode("cmd=gomid&newmid=$mid&sid=$sid");

// View equipment
$cmd = $encode->encode("cmd=zbinfo&id=$id&sid=$sid");

// Start cultivation
$cmd = $encode->encode("cmd=goxiulian&sid=$sid");
```

### After (New English):
```php
// Go to map
$cmd = $encode->encode("cmd=goto_map&newmid=$mid&sid=$sid");

// View equipment
$cmd = $encode->encode("cmd=equipment_info&id=$id&sid=$sid");

// Start cultivation
$cmd = $encode->encode("cmd=goto_cultivation&sid=$sid");
```

## Notes

- All command names now use snake_case (lowercase with underscores)
- Command names are more descriptive and self-documenting
- This improves code readability and maintainability
- No backward compatibility with old Chinese pinyin commands

## Date Updated
2025-11-13
