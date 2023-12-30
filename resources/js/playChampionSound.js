/* The code snippet defines a JavaScript module that exports a function called `playChampionSound`. */
let currentAudio;

export const playChampionSound = (element) => {
    const championId = element.dataset.championId;
    const soundUrl = `https://cdn.communitydragon.org/latest/champion/${championId}/champ-select/sounds/choose`;

    if (currentAudio) {
        if (currentAudio.dataset.championId === championId) {
            return;
        }
        currentAudio.pause();
        currentAudio.currentTime = 0;
    }

    currentAudio = new Audio(soundUrl);
    currentAudio.dataset.championId = championId;

    currentAudio.play();

    currentAudio.addEventListener('ended', () => {
        currentAudio = null;
    });
};
