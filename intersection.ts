
// 交差型 => intersection-型 を理解する

// intersection: 交差点

type RobotamaNanoda = {
    name: string;
    purupuruFlag: boolean;
};


type Weapon = {
    power: number;
    skill: string;
};


// 両方を兼ね備えた型を作成する
type SuperRobotama = RobotamaNanoda & Weapon;


const robotama: RobotamaNanoda = {
    name: 'ロボ玉',
    purupuruFlag: true,
}


const machineGun: Weapon = {
    power: 20000,
    skill: 'マルチロックオン',
}


const ArmedRobotama: SuperRobotama = {
    name: 'ロボ玉',
    purupuruFlag: false,
    power: 20000,
    skill: 'マルチロックオン',
}

