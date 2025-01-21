<template>
  <div id="game-container">
    <MainHeader></MainHeader>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue';
import Phaser from 'phaser';
import city_background from '@/assets/images/city/city_background.png';

export default {
  setup() {
    // Initialize Phaser game instance on component mount
    onMounted(() => {
      const config = {
        type: Phaser.AUTO,
        width: 1280,
        height: 630,
        physics: {
          default: 'arcade',
          arcade: {
            gravity: { y: 300 },
            debug: false,
          },
        },
        scene: {
          preload: preload,
          create: create,
          update: update,
        },
      };

      let player;
      let platforms;
      let cursors;
      let stars;

      const game = new Phaser.Game(config);
      game.sound.mute = true;
      let score = 0;
      let scoreText;

      function preload() {
        // this.load.image('city', new URL('./assets/img.png', import.meta.url).href');
        // console.log(new URL('@/assets/images/city/city_background.png', import.meta.url).href);

        this.load.image('city', new URL('@/assets/images/city/city_background.png', import.meta.url).href);
        this.load.image('platform_white', new URL('@/assets/images/city/platform_white.png', import.meta.url).href);
        this.load.image('plants', new URL('@/assets/images/city/plants-1.png', import.meta.url).href);
        this.load.image('ground', new URL('@/assets/images/city/platform.png', import.meta.url).href);
        this.load.image('star', new URL('@/assets/images/city/star.png', import.meta.url).href);
        this.load.image('bomb', new URL('@/assets/images/city/bomb.png', import.meta.url).href);
        this.load.spritesheet('dude', new URL('@/assets/images/city/dude.png', import.meta.url).href, {
          frameWidth: 32,
          frameHeight: 48,
        });
      }

      function create() {
        game.sound.mute = true;
        const platformsWhite = this.physics.add.staticGroup();
        platformsWhite.create(430, 362, 'platform_white').setScale().refreshBody();
        platformsWhite.create(120, 218, 'platform_white').setScale().refreshBody();
        platformsWhite.create(120, 425, 'platform_white').setScale().refreshBody();
        platformsWhite.create(1110, 390, 'platform_white').setScale().refreshBody();
        platformsWhite.create(975, 90, 'platform_white').setScale().refreshBody();
        platformsWhite.create(1335, 255, 'platform_white').setScale().refreshBody();
        platformsWhite.create(565, 150, 'platform_white').setScale().refreshBody();

        this.add.image(640, 315, 'city').setScale(0.7);
        player = this.physics.add.sprite(100, 450, 'dude');

        player.setBounce(0.2);
        player.setCollideWorldBounds(true);

        platforms = this.physics.add.staticGroup();
        platforms.create(400, 568, 'plants').setScale().refreshBody();

        // platforms.create(600, 400, 'ground');
        // platforms.create(50, 250, 'ground');
        // platforms.create(750, 220, 'ground');

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

        cursors = this.input.keyboard.createCursorKeys();

        this.physics.add.collider(player, platforms);
        this.physics.add.collider(player, platformsWhite);

        stars = this.physics.add.group({
          key: 'star',
          repeat: 24,
          setXY: { x: 25, y: 0, stepX: 50 },
        });
        stars.children.iterate(function (child) {
          child.setBounceY(Phaser.Math.FloatBetween(0.4, 0.8));
        });

        this.physics.add.collider(stars, platforms);
        this.physics.add.collider(stars, platformsWhite);

        this.physics.add.overlap(player, stars, collectStar, null, this);

        function collectStar(player, star) {
          star.disableBody(true, true);
        }

        scoreText = this.add.text(16, 16, 'score: 0', { fontSize: '32px', fill: '#000' });

        function collectStar(player, star) {
          star.disableBody(true, true);

          score += 10;
          scoreText.setText('Score: ' + score);

          if (stars.countActive(true) === 0) {
            stars.children.iterate(function (child) {
              child.enableBody(true, child.x, 0, true, true);
            });

            const x = player.x < 400 ? Phaser.Math.Between(400, 800) : Phaser.Math.Between(0, 400);

            const bomb = bombs.create(x, 16, 'bomb');
            bomb.setBounce(1);
            bomb.setCollideWorldBounds(true);
            bomb.setVelocity(Phaser.Math.Between(-200, 200), 20);
          }
        }

        const bombs = this.physics.add.group();

        this.physics.add.collider(bombs, platforms);

        this.physics.add.collider(player, bombs, hitBomb, null, this);
        function hitBomb(player, bomb) {
          this.physics.pause();

          player.setTint(0xff0000);

          player.anims.play('turn');

          gameOver = true;
        }
      }

      function update() {
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
    });

    return {};
  },
};
</script>

<style>
#game-container {
  width: 100%;
  height: 100%;
  /* margin-top: 80px; */
  header {
    position: static;
  }
}
</style>
