import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/controls/OrbitControls";
import { OBJLoader } from "three/examples/jsm/loaders/OBJLoader";

// CAMERA
const camera: THREE.PerspectiveCamera = new THREE.PerspectiveCamera(
  30,
  window.innerWidth / window.innerHeight,
  1,
  15000
);
camera.position.set(0, 2000, 100);
camera.lookAt(new THREE.Vector3(0, 0, 0));

// RENDERER
const renderer: THREE.WebGLRenderer = new THREE.WebGLRenderer({
  antialias: true,
});
renderer.setPixelRatio(window.devicePixelRatio);
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.shadowMap.enabled = true;
document.body.appendChild(renderer.domElement);

// WINDOW RESIZE HANDLING
export function onWindowResize() {
  camera.aspect = window.innerWidth / window.innerHeight;
  camera.updateProjectionMatrix();
  renderer.setSize(window.innerWidth, window.innerHeight);
}
window.addEventListener("resize", onWindowResize);

// SCENE
const scene: THREE.Scene = new THREE.Scene();
scene.background = new THREE.Color(0xbfd1e6);

// CONTROLS
const controls = new OrbitControls(camera, renderer.domElement);

export function animate() {
  dragObject();
  renderer.render(scene, camera);
  requestAnimationFrame(animate);
}

// ambient light
let hemiLight = new THREE.AmbientLight(0xffffff, 0.2);
scene.add(hemiLight);

//Add directional light
let dirLight = new THREE.DirectionalLight(0xffffff, 1);
dirLight.position.set(-30, 50, -30);
scene.add(dirLight);
dirLight.castShadow = true;
dirLight.shadow.mapSize.width = 2048;
dirLight.shadow.mapSize.height = 2048;
dirLight.shadow.camera.left = -70;
dirLight.shadow.camera.right = 70;
dirLight.shadow.camera.top = 70;
dirLight.shadow.camera.bottom = -70;

function createFloor() {
  let pos = { x: 0, y: -1, z: 3 };
  let scale = { x: 1000, y: 1, z: 1000 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "#f8f4e2" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.ground = true;
}
// flour1
function createFloor1() {
  let pos = { x: -150, y: -1, z: 440 };
  let scale = { x: 100, y: 3, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "blue" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
// flour2
function createFloor2() {
  let pos = { x: -150, y: -1, z: 440 };
  let scale = { x: 100, y: 3, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "white" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
// flour3
function createFloor3() {
  let pos = { x: -150, y: -1, z: 440 };
  let scale = { x: 100, y: 3, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "#e29e6a" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}

function wall() {
  let pos = { x: -250, y: 50, z: 440 };
  let scale = { x: 1, y: 100, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "#f9d7e6" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
function wall1() {
  let pos = { x: -250, y: 50, z: 440 };
  let scale = { x: 1, y: 100, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "#e29e6a" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
function wall2() {
  let pos = { x: -250, y: 50, z: 440 };
  let scale = { x: 1, y: 100, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "white" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);

  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
function wall3() {
  let pos = { x: -350, y: 50, z: 440 };
  let scale = { x: 1, y: 100, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "grey" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);
  blockPlane.rotation.y += 1.5;
  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
function wall5() {
  let pos = { x: -350, y: 50, z: 440 };
  let scale = { x: 1, y: 100, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "white" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);
  blockPlane.rotation.y += 1.5;
  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}
function wall6() {
  let pos = { x: -350, y: 50, z: 440 };
  let scale = { x: 1, y: 100, z: 100 };

  let blockPlane = new THREE.Mesh(
    new THREE.BoxBufferGeometry(),
    new THREE.MeshBasicMaterial({ color: "red" })
  );
  blockPlane.position.set(pos.x, pos.y, pos.z);
  blockPlane.scale.set(scale.x, scale.y, scale.z);
  // blockPlane.castShadow = true;
  // blockPlane.receiveShadow = true;
  scene.add(blockPlane);
  blockPlane.rotation.y += 1.5;
  blockPlane.userData.draggable = true;
  blockPlane.userData.name = "CASTLE";
}

function Bed1() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./bed.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 70;
    castle.position.z = 480;
    castle.position.y = 2;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 25;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("blue"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function Bed2() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./bed.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 10;
    castle.position.z = 480;
    castle.position.y = 2;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 25;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("orange"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function Bed3() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./bed.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = -15;
    castle.position.z = 480;
    castle.position.y = 2;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 25;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("white"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function Bed4() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./bed.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 50;
    castle.position.z = 480;
    castle.position.y = 2;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 25;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("green"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function drawer1() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./drawer.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 350;
    castle.position.z = 480;
    castle.position.y = 5;

    castle.scale.x = 15;
    castle.scale.y = 12;
    castle.scale.z = 15;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("blue"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}

function drawer2() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./drawer.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 370;
    castle.position.z = 480;
    castle.position.y = 5;

    castle.scale.x = 15;
    castle.scale.y = 12;
    castle.scale.z = 15;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("white"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function drawer3() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./drawer.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 390;
    castle.position.z = 480;
    castle.position.y = 5;

    castle.scale.x = 15;
    castle.scale.y = 12;
    castle.scale.z = 15;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("red"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}

function cabinetry1() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./cabinatory.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 300;
    castle.position.z = 480;
    castle.position.y = 7;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 20;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("red"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function cabinetry2() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./cabinatory.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 285;
    castle.position.z = 480;
    castle.position.y = 7;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 20;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("orange"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function cabinetry3() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./cabinatory.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 270;
    castle.position.z = 480;
    castle.position.y = 7;

    castle.scale.x = 20;
    castle.scale.y = 18;
    castle.scale.z = 20;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("green"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}
function shoes1() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./shoes.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 250;
    castle.position.z = 480;
    castle.position.y = 3;

    castle.scale.x = 20;
    castle.scale.y = 10;
    castle.scale.z = 20;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("green"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}

function shoes2() {
  const objLoader = new OBJLoader();

  objLoader.loadAsync("./shoes.obj").then((group) => {
    const castle = group.children[0];

    castle.position.x = 235;
    castle.position.z = 480;
    castle.position.y = 3;

    castle.scale.x = 20;
    castle.scale.y = 10;
    castle.scale.z = 20;

    // castle.castShadow = true
    // castle.receiveShadow = true

    castle.userData.draggable = true;
    castle.userData.name = "CASTLE";

    castle.traverse((child) => {
      if (child instanceof THREE.Mesh) {
        // Asserting the material type
        const meshMaterial = child.material as THREE.MeshBasicMaterial;
        // Set color for each material
        meshMaterial.color.set("orange"); // Set to red color, change as needed
      }
    });

    scene.add(castle);
  });
}

const raycaster = new THREE.Raycaster(); // create once
const clickMouse = new THREE.Vector2(); // create once
const moveMouse = new THREE.Vector2(); // create once
var draggable: THREE.Object3D;

function intersect(pos: THREE.Vector2) {
  raycaster.setFromCamera(pos, camera);
  return raycaster.intersectObjects(scene.children);
}

window.addEventListener("click", (event) => {
  if (draggable != null) {
    console.log(`dropping draggable ${draggable.userData.name}`);
    draggable = null as any;
    return;
  }

  // THREE RAYCASTER
  clickMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  clickMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

  const found = intersect(clickMouse);
  if (found.length > 0) {
    if (found[0].object.userData.draggable) {
      draggable = found[0].object;
      console.log(`found draggable ${draggable.userData.name}`);
    }
  }
});

window.addEventListener("mousemove", (event) => {
  moveMouse.x = (event.clientX / window.innerWidth) * 2 - 1;
  moveMouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
});

function dragObject() {
  if (draggable != null) {
    const found = intersect(moveMouse);
    if (found.length > 0) {
      for (let i = 0; i < found.length; i++) {
        if (!found[i].object.userData.ground) continue;

        let target = found[i].point;
        draggable.position.x = target.x;
        draggable.position.z = target.z;
      }
    }
  }
}

createFloor();
createFloor3();
createFloor2();
createFloor1();
Bed1();
Bed2();
Bed3();
Bed4();
animate();
wall();
wall1();
wall2();
wall3();
wall5();
wall6();
drawer1();
drawer2();
drawer3();
cabinetry1();
cabinetry2();
cabinetry3();
shoes1();
shoes2();

// box
// function createBox() {
//   let scale = { x: 6, y: 6, z: 6 }
//   let pos = { x: 15, y: scale.y / 2, z: 15 }

//   let box = new THREE.Mesh(new THREE.BoxBufferGeometry(),
//       new THREE.MeshPhongMaterial({ color: 0xDC143C }));
//   box.position.set(pos.x, pos.y, pos.z);
//   box.scale.set(scale.x, scale.y, scale.z);
//   box.castShadow = true;
//   box.receiveShadow = true;
//   scene.add(box)

//   box.userData.draggable = true
//   box.userData.name = 'BOX'
// }

// function createSphere() {
//   let radius = 4;
//   let pos = { x: 15, y: radius, z: -15 };

//   let sphere = new THREE.Mesh(new THREE.SphereBufferGeometry(radius, 32, 32),
//       new THREE.MeshPhongMaterial({ color: 0x43a1f4 }))
//   sphere.position.set(pos.x, pos.y, pos.z)
//   sphere.castShadow = true
//   sphere.receiveShadow = true
//   scene.add(sphere)

//   sphere.userData.draggable = true
//   sphere.userData.name = 'SPHERE'
// }

// function createCylinder() {
//   let radius = 4;
//   let height = 6
//   let pos = { x: -15, y: height / 2, z: 15 };

//   // threejs
//   let cylinder = new THREE.Mesh(new THREE.CylinderBufferGeometry(radius, radius, height, 32), new THREE.MeshPhongMaterial({ color: 0x90ee90 }))
//   cylinder.position.set(pos.x, pos.y, pos.z)
//   cylinder.castShadow = true
//   cylinder.receiveShadow = true
//   scene.add(cylinder)

//   cylinder.userData.draggable = true
//   cylinder.userData.name = 'CYLINDER'
// }
