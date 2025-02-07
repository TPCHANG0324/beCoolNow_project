<template>
  <div class="gameWrapper">
    <MainHeader></MainHeader>
    <div id="gameContainer" ref="gameContainer"></div>
  </div>
</template>

<script>
import { watch, onMounted, ref, onUnmounted } from 'vue';
import { useRoute } from "vue-router";
import Phaser from 'phaser';
import MainHeader from "@/components/layout/MainHeader.vue";
import gsap from "gsap";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { FontFamily } from 'ckeditor5';

gsap.registerPlugin(ScrollToPlugin); // ✅ 註冊 ScrollToPlugin

export default {
  comments:{
    MainHeader,
  },
  setup() {
    const route = useRoute();

    const updateHeaderPosition = () => {
      const header = document.querySelector("header");
      if (!header) return;

      if (route.path === "/city") {
        header.style.position = "static";
        header.style.top = "0";
      } else {
        header.style.position = "fixed";
        header.style.top = "0";
      }
    };

    watch(
      () => route.path,
      () => {
        updateHeaderPosition();
      },
      { immediate: true }
    );


    // ✅ Vue 3 的 `ref`，用來綁定遊戲的 DOM 容器
    const gameContainer = ref(null);

    // ✅ 使用 Vue 3 的 `ref` 來確保 UI 可以即時更新
    const score = ref(0);

    // ✅ 遊戲內部變數
    var player, ground, cursors, stars, bombs, platformsWhite;
    var gameOver = false; // ✅ 用來檢查遊戲是否結束

    let scrollAnimation = null; // ✅ 儲存 GSAP 動畫

    onMounted(() => {
      // 監聽 DOM 變化，確保 `header` 被渲染
      const observer = new MutationObserver(() => {
      updateHeaderPosition();
      });

      observer.observe(document.body, { childList: true, subtree: true });

      // ✅ **進入頁面時立即檢查**
      updateHeaderPosition();

      if (gameContainer.value) {
        gameContainer.value.innerHTML = ""; // 清除舊遊戲畫面
      }

      // ✅ Phaser 遊戲設定
      const config = {
        type: Phaser.AUTO, // ✅ 自動選擇 WebGL 或 Canvas
        width: 1280, // ✅ 遊戲畫面的寬度
        height: 630, // ✅ 遊戲畫面的高度
        physics: {
          default: 'arcade', // ✅ 使用 Arcade 物理系統
          arcade: {
            gravity: { y: 300 }, // ✅ 設定重力，讓角色能夠跳躍
            debug: false, // ✅ 關閉偵錯模式
          },
        },
        parent: gameContainer.value, // ✅ Phaser 遊戲將綁定 Vue 元素
        scene: {
          preload: preload, // ✅ 載入資源
          create: create,   // ✅ 創建遊戲物件
          update: update    // ✅ 更新遊戲邏輯
        },
      };

      // ✅ 創建 Phaser 遊戲實例
      const game = new Phaser.Game(config);
      game.sound.mute = true; // ✅ 關閉遊戲音效

      // **📌 預載入遊戲素材**
      function preload() {
        this.load.image('city', new URL('@/assets/images/city/city_background.png', import.meta.url).href);
        this.load.image('platform_white', new URL('@/assets/images/city/platform_white.png', import.meta.url).href);
        this.load.image('ground', new URL('@/assets/images/city/city_ground.png', import.meta.url).href);
        this.load.image('star', new URL('@/assets/images/city/star.png', import.meta.url).href);
        this.load.image('bomb', new URL('@/assets/images/city/bomb.png', import.meta.url).href);
        this.load.spritesheet('dude', new URL('@/assets/images/city/dude.png', import.meta.url).href, {
          frameWidth: 32,
          frameHeight: 48,
        });
      }

      // **📌 遊戲初始化**
      function create() {
        gameOver = false; // ✅ 遊戲重新開始時重置 `gameOver`

        // ✅ 確保動畫不重複創建
        if (this.anims.exists('left')) {
          this.anims.remove('left');
        }
        if (this.anims.exists('turn')) {
          this.anims.remove('turn');
        }
        if (this.anims.exists('right')) {
          this.anims.remove('right');
        }

        // ✅ 讓 Phaser 不攔截滑鼠滾輪事件
        this.input.mouse.disableContextMenu(); // 防止右鍵菜單
        this.input.manager.enabled = true; // 停用 Phaser 內建輸入管理器，避免影響滾動
        this.input.mouse.enabled = true;  // ✅ 確保滑鼠滾動可用
        this.input.keyboard.enabled = true; // ✅ 確保鍵盤可用
        this.input.setTopOnly(false); // ✅ 確保點擊不會被 Phaser 遮擋

        // ✅ **確保只創建一次彈窗**
        if (!this.popupBackground) {
          // ✅ **半透明遮罩**
          this.overlay = this.add.rectangle(640, 315, 1280, 630, 0x000000, 0.7);
          this.overlay.setDepth(10); // ✅ 確保遮罩在最上層

          // ✅ **彈窗背景**
          this.popupBackground = this.add.graphics();
          this.popupBackground.fillStyle(0xe6eccc, 1); // ✅ **背景顏色**
          this.popupBackground.fillRoundedRect(450, 200, 380, 250, 10); // ✅ **圓角 (10px)**
          this.popupBackground.lineStyle(2, 0xd0ad44); // ✅ **邊框**
          this.popupBackground.strokeRoundedRect(450, 200, 380, 250, 10); // ✅ **繪製邊框**
          this.popupBackground.setDepth(11); // ✅ **確保背景不會被蓋住**

          // ✅ **遊戲規則文字**
          this.instructions = this.add.text(
            640, 290,
            "遊戲規則：\n- 使用方向鍵左右移動角色\n- 按 ↑ 鍵跳躍\n- 收集星星來獲取分數\n- 小心炸彈，碰到炸彈遊戲結束！",
            {
              fontSize: "18px",
              FontFamily: 'DM Sans, Noto Sans',
              color: "#2e4e3f",
              align: "center",
              wordWrap: { width: 400 },
              padding: { top: 10, bottom: 5 }, // ✅ **增加內邊距**
              lineSpacing: 8, // ✅ **增加行距**
            }
          );
          this.instructions.setOrigin(0.5, 0.5);
          this.instructions.setDepth(12);

          // ✅ **開始按鈕**
          this.startButton = this.add.text(640, 400, "開始遊戲", {
            fontSize: "26px",
            backgroundColor: "#5b774a",
            color: "#e6eccc",
            FontFamily: 'DM Sans, Noto Sans',
            padding: { x: 20, y: 10 },
          })
          .setOrigin(0.5)
          .setInteractive()
          .setDepth(12);

          // 🎯 **點擊按鈕後開始遊戲**
          this.startButton.on("pointerdown", () => {
            console.log("✅ 遊戲開始！");

            // ✅ **防止多次點擊**
            this.startButton.disableInteractive();

            // ✅ **確保所有 UI 元素已刪除**
            if (this.overlay) {
              console.log("🔄 移除遮罩");
              this.overlay.destroy();
              this.overlay = null;
            }

            if (this.popupBackground) {
              console.log("🔄 移除彈窗背景");
              this.popupBackground.destroy();
              this.popupBackground = null;
            }

            if (this.instructions) {
              console.log("🔄 移除遊戲說明");
              this.instructions.destroy();
              this.instructions = null;
            }

            if (this.startButton) {
              console.log("🔄 移除開始按鈕");
              this.startButton.destroy();
              this.startButton = null;
            }

            console.log("🎯 所有彈窗元素已成功刪除！");
          });
        }


        // ✅ **恢復 Phaser 的輸入系統**
        this.input.setTopOnly(false);
        this.input.mouse.enabled = true; // ✅ 確保滑鼠輸入可用
        this.input.keyboard.enabled = true; // ✅ 確保鍵盤輸入可用

        // ✅ **確保遊戲先暫停，等玩家點擊「開始遊戲」後才運行**
        this.physics.pause();

        // ✅ **重新啟動遊戲物理引擎**
        this.physics.resume();





        // ✅ 添加背景
        this.add.image(640, 315, 'city').setScale(0.7);

        // ✅ 建立白色平台（靜態）
        platformsWhite = this.physics.add.staticGroup();
        platformsWhite.create(430, 362, 'platform_white').refreshBody();
        platformsWhite.create(120, 218, 'platform_white').refreshBody();
        platformsWhite.create(120, 425, 'platform_white').refreshBody();
        platformsWhite.create(1110, 390, 'platform_white').refreshBody();
        platformsWhite.create(975, 90, 'platform_white').refreshBody();
        platformsWhite.create(1335, 255, 'platform_white').refreshBody();
        platformsWhite.create(565, 150, 'platform_white').refreshBody();

        // ✅ 地面（靜態）
        ground = this.physics.add.staticGroup();
        ground.create(400, 568, 'ground').refreshBody();

        // ✅ 玩家角色
        player = this.physics.add.sprite(100, 450, 'dude');
        player.setBounce(0.2); // ✅ 讓角色有彈性
        player.setCollideWorldBounds(true); // ✅ 角色不會掉出場外

        // ✅ 角色動畫設定
        this.anims.create({
          key: 'left',
          frames: this.anims.generateFrameNumbers('dude', { start: 0, end: 3 }),
          frameRate: 10,
          repeat: -1,
        });

        this.anims.create({
          key: 'turn',
          frames: [{ key: 'dude', frame: 4 }],
          frameRate: 20,
        });

        this.anims.create({
          key: 'right',
          frames: this.anims.generateFrameNumbers('dude', { start: 5, end: 8 }),
          frameRate: 10,
          repeat: -1,
        });

        // ✅ 建立鍵盤輸入
        cursors = this.input.keyboard.createCursorKeys();
        console.log('偵測到cursors', cursors);


        // ✅ 設定碰撞
        this.physics.add.collider(player, ground);
        this.physics.add.collider(player, platformsWhite);

        // ✅ 星星群組
        stars = this.physics.add.group({
          key: 'star',
          // repeat: 24,
          repeat: 0,
          setXY: { x: 25, y: 0, stepX: 50 },
        });

        // ✅ 讓星星有隨機彈跳
        stars.children.iterate((child) => {
          child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));
        });

        // ✅ 星星碰撞
        this.physics.add.collider(stars, ground);
        this.physics.add.collider(stars, platformsWhite);
        this.physics.add.overlap(player, stars, collectStar, null, this);

        // ✅ 建立炸彈群組
        bombs = this.physics.add.group();
        this.physics.add.collider(bombs, ground);
        this.physics.add.collider(player, bombs, hitBomb, null, this);

        // ✅ 設定分數顯示
        const scoreText = this.add.text(40, 20, '總分: 0', { fontSize: '28px', fill: 'black', FontFamily: 'DM Sans, Noto Sans', padding: { x: 1, y: 5 }, });

        // 📌 **收集星星**
        function collectStar(player, star) {
          star.disableBody(true, true);
          score.value += 10; // ✅ Vue 的 `ref()` 更新分數
          scoreText.setText('總分: ' + score.value);

          // ✅ 當所有星星被收集時，重新生成並放置炸彈
          if (stars.countActive(true) === 0) {
            stars.children.iterate((child) => {
              child.enableBody(true, child.x, 0, true, true);
            });

            const x = player.x < 400 ? Phaser.Math.Between(400, 800) : Phaser.Math.Between(0, 400);
            const bomb = bombs.create(x, 16, 'bomb');
            bomb.setBounce(1);
            bomb.setCollideWorldBounds(true);
            bomb.setVelocity(Phaser.Math.Between(-200, 200), 20);
          }
        }

        // 📌 **當玩家碰到炸彈，遊戲結束**
        function hitBomb(player, bomb) {
          this.physics.pause();
          player.setTint(0xff0000);
          player.anims.play('turn');
          gameOver = true;

          console.log("遊戲結束，顯示 Restart 按鈕");

          // ✅ **確保不會重複創建「重新開始」按鈕**
          if (this.restartButton) {
            this.restartButton.destroy();
            console.log("🔄 已移除舊的 Restart 按鈕");
          }

          // ✅ 按鈕背景
          const buttonWidth = 180;
          const buttonHeight = 60;
          const buttonX = 640 - buttonWidth / 2; // 居中對齊
          const buttonY = 350 - buttonHeight / 2;
          const borderRadius = 15; // ✅ 圓角半徑

          // ✅ 使用 graphics 繪製圓角按鈕背景
          this.restartButtonBg = this.add.graphics();
          this.restartButtonBg.fillStyle(0x5b774a, 1); // ✅ **背景顏色**
          this.restartButtonBg.fillRoundedRect(buttonX, buttonY, buttonWidth, buttonHeight, borderRadius);
          this.restartButtonBg.lineStyle(2, 0xd0ad44); // ✅ **邊框顏色**
          this.restartButtonBg.strokeRoundedRect(buttonX, buttonY, buttonWidth, buttonHeight, borderRadius);
          this.restartButtonBg.setDepth(14); // ✅ 確保背景在文字下方

          // ✅ 創建新的 Restart 按鈕
          this.restartButton = this.add.text(640, 350, '重新開始', {
            fontSize: '26px',
            color: '#e6eccc',
            fontFamily: 'DM Sans, Noto Sans'
          })
            .setOrigin(0.5)
            .setInteractive()
            .setDepth(15); // ✅ **確保在最上層**

          console.log("✅ Restart 按鈕已創建");

          setTimeout(() => {
            if (this.restartButton) {
              this.restartButton.on("pointerdown", () => {
                console.log("🎮 按下 Restart 按鈕，準備重新啟動遊戲");
                restartGame(this);
              });
            }
          }, 50);
        }

        // 📌 **重新開始遊戲**
        function restartGame(scene) {
          console.log("重新開始遊戲");

          // ✅ 移除舊動畫，確保重新載入場景時不會有衝突
          scene.anims.remove('left');
          scene.anims.remove('turn');
          scene.anims.remove('right');

          // ✅ 先停止場景，確保所有物件被清除
          scene.scene.stop();
          scene.scene.start(); // ✅ 重新啟動場景

          // scene.scene.restart();
          score.value = 0; // ✅ 重置分數
          gameOver = false; // ✅ 確保 `gameOver` 變數重置

          // ✅ 確保 `restartButton` 不會累積
          if (scene.restartButton) {
            scene.restartButton.destroy();
            scene.restartButton = null;
          }
        }
      }

      // 📌 **更新函式**
      function update() {

        if (!cursors) {
        cursors = this.input.keyboard.createCursorKeys(); // 確保 `cursors` 存在
        }

        if (cursors.left.isDown) {
          player.setVelocityX(-160);
          player.anims.play('left', true);
        } else if (cursors.right.isDown) {
          player.setVelocityX(160);
          player.anims.play('right', true);
        } else {
          player.setVelocityX(0);
          player.anims.play('turn');
        }

        if (cursors.up.isDown && player.body.touching.down) {
          player.setVelocityY(-320);
        }
      }

      const enableScroll = (event) => {
        if (event.target.closest(".phaser-container")) {
          return; // ✅ 避免 Phaser 內部攔截
        }

        event.stopPropagation(); // ✅ 確保 Phaser 不攔截事件
        event.preventDefault();  // ✅ 避免 Phaser 阻止滾動

        // ✅ 使用 GSAP 讓滾動更流暢
        scrollAnimation = gsap.to(window, {
          duration: 5, // ✅ 滾動時間（數值越大越平滑）
          ease: "power3.out", // ✅ 使用 GSAP 平滑效果
          scrollTo: {
            y: window.scrollY + event.deltaY * 5, // ✅ 讓滾動距離與滾輪速度相符
            autoKill: false, // ✅ 防止 GSAP 自動停止滾動
          },
        });
      };

      // ✅ 監聽滑鼠滾輪事件，讓網頁可以正常滾動
      window.addEventListener("wheel", enableScroll, { passive: false });

      onUnmounted(() => {
        window.removeEventListener("wheel", enableScroll);

        if (game) {
            game.destroy(true); // ✅ 清除遊戲，避免鍵盤失效
        }

        if (scrollAnimation) {
          scrollAnimation.kill(); // ✅ 停止 GSAP 動畫
        }
        gsap.globalTimeline.clear(); // ✅ 清除所有 GSAP 動畫

      });

    });


    return {
      gameContainer,
      score,
    };
  },
};

</script>

<style>
.game-wrapper {
  display: flex;
  flex-direction: column; /* ✅ 讓 Header 在上，Game 在下 */
  height: 100vh; /* ✅ 讓畫面滿版 */
}

#gameContainer {
  width: 100%;
  flex-grow: 1; /* ✅ 讓遊戲區塊佔據剩餘的空間 */
  height: calc(100vh - 80px); /* ✅ 讓遊戲畫面填滿剩餘空間 */
}
</style>
