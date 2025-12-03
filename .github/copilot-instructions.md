# XXJserver - Võ Hiệp Game (寻仙记) Development Guide

## Tổng quan kiến trúc

Đây là một text-based web game dạng võ hiệp/tu tiên viết bằng PHP thuần, không sử dụng framework. Game sử dụng kiến trúc monolithic với routing thủ công qua query parameters.

### Luồng request chính

1. **Entry point**: `game.php` - Front controller xử lý tất cả game requests
2. **Routing**: URL encode/decode qua `class/encode.php` với format `?cmd=encoded_string`
3. **Command routing**: Switch-case trong `game.php` map `cmd` parameter tới file xử lý tương ứng trong thư mục `game/`
4. **View rendering**: Mỗi file game logic include và set biến `$ym` (đường dẫn view file)

```php
// Ví dụ luồng request
?cmd=pvbgj&bossid=123&sid=abc  // URL được encode
→ game.php decode và parse
→ switch case 'pvbgj' → $ym = 'game/boss.php'
→ include 'game/boss.php' để xử lý logic và render
```

### Database layer

- **Connection**: `pdo.php` - PDO connection singleton
- **Tables chính**: 
  - `game1` - player data (sid là primary key)
  - `boss` / `yboss` - boss và boss instances
  - `npc` - NPCs và quest givers  
  - `mid` - maps/locations
  - `zhuangbei` - equipment items
  - `ggliaotian` - global chat

### Core classes & namespaces

```php
namespace player;  // Tất cả game logic trong namespace này

class player {    // Player entity với ~50 properties
    var $sid;     // Session ID - primary identifier
    var $uname;   // Username
    var $ulv, $uhp, $ugj, $ufy;  // Level, HP, Attack, Defense
    // ... stats, equipment slots, currencies
}

class guaiwu {}   // Monster entities
class boss {}     // Boss entities  
class npc {}      // NPC entities

// Global helper functions (trong namespace player)
function getplayer($sid, $dblj)  // Load player by session ID
function getboss($bossid, $dblj) // Load boss data
function getnpc($nid, $dblj)     // Load NPC data
```

### Quy ước đặt tên hiện tại

**Biến player attributes** (Vietnamese-pinyin mix):
- `u*` prefix = user/player: `ulv` (level), `uhp` (HP), `ugj` (attack), `ufy` (defense)
- `*yxb` = game currency (灵石), `uczb` = premium currency
- `nowmid` = current map ID
- `sid` = session/player unique ID
- `nid` = NPC ID, `mid` = map ID, `gid` = monster ID

**File naming**:
- `game/*.php` - game logic modules: `boss.php`, `pve.php`, `bagzb.php` (bag equipment)
- `npc/muban/*.php` - NPC interaction templates
- Vietnamese mixed với Chinese: `zhuangbei` (装备 equipment), `zhuangtai` (状态 status)

### Session & Rate limiting

```php
// Anti-spam: 220ms minimum between POST requests
$allow_sep = "220";
$_SESSION["post_sep"] = getMillisecond();

// Player session tracking
$player->sfzx = 1;  // Online status flag
$player->endtime;   // Last activity timestamp
```

### URL encoding system

**Mục đích**: Obfuscate game parameters và prevent tampering

```php
// Encode: Base64 + character interleaving với key 'cxphp'
$encode->encode("cmd=gomid&newmid=5&sid=abc123")

// Một số commands cần re-encode sau xử lý
shouldReencode($cmd) // ['cjplayer','djinfo','zbinfo','npc','duihuan','shangdian','sendliaotian']
```

### Combat system

**PvE flow** (`game/pve.php`):
1. Load player + monster stats
2. Calculate damage với công thức: `base_attack * random_multiplier - defense`
3. Apply buffs từ equipment, pets, skills
4. Update HP, check death, distribute rewards

**Boss battles** (`game/boss.php`):
- Shared boss instances (`yboss` table) - multiplayer damage tracking
- Potion usage system: `yp1`, `yp2`, `yp3` slots
- Pet combat bonuses: `$cwhurt` (pet damage contribution)

### Equipment & Inventory

- **Equipment slots**: `tool1` - `tool7` (7 slots)
- **Consumable slots**: `yp1`, `yp2`, `yp3` (potions)
- **Skill slots**: `jn1`, `jn2`, `jn3`
- Inventory views: `bagzb.php` (equipment), `bagyp.php` (potions), `bagjn.php` (skills)

### NPC interaction pattern

```php
// npc/npc.php loads NPC, checks quests
$npc = player\getnpc($nid, $dblj);

// Template system: npc/muban/{template}.php
// Switch $canshu parameter để handle different NPC actions
switch ($canshu) {
    case 'aomen':  // Gambling/minigame
    case 'czyxb':  // Currency exchange
    // ...
}
```

### GM/Admin tools

`gm/gm.php` - Web-based admin panel:
- Player stat modification
- Currency injection  
- Level/exp adjustment
- Requires `checknum` password validation

## Development workflows

### Adding new game feature

1. Thêm `case` trong `game.php` switch statement
2. Tạo file xử lý trong `game/` folder
3. Load player: `$player = \player\getplayer($sid, $dblj);`
4. Process logic, update database
5. Render output hoặc redirect với encoded URL

### Database queries

```php
// Luôn dùng prepared statements
$sql = "UPDATE game1 SET uhp=? WHERE sid=?";
$stmt = $dblj->prepare($sql);
$stmt->execute(array($new_hp, $sid));

// Bind columns khi fetch
$cxjg->bindColumn('uname', $player->uname);
$ret = $cxjg->fetch(PDO::FETCH_ASSOC);
```

### Testing locally

- Requires MySQL database named `game`
- Import schema từ `数据库5.5-5.6====PHP5.6/` folder
- Configure credentials trong `pdo.php`
- Access via `index.php` cho login, `game.php` cho gameplay

## Common pitfalls

- **Không unset session variables**: Session data persist, nhớ clear khi cần
- **SQL injection**: Luôn dùng prepared statements, không concatenate user input
- **Rate limiting bypass**: Check `$_SESSION["post_sep"]` timing
- **URL decode issues**: Một số commands cần re-encode sau processing
- **Player state sync**: Reload player object sau mỗi database update để tránh stale data

## Code style notes

- Mixed Vietnamese/Chinese/English comments - preserve khi edit
- HTML heredoc syntax (`<<<HTML ... HTML;`) cho output rendering
- Global namespace functions trong `namespace player`
- Variable naming không consistent - giữ nguyên để tránh break existing code
- Error reporting disabled (`error_reporting(0)`) - enable khi debug
