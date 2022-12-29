import Energy from "../../../apis/Energy";
import store from "../../../vuex/store";

export default {
    getSitePowerAlarms(siteCode) {
        let data = {
            site_code: siteCode,
        };

        store.dispatch("displaySpinnerPage", false);
        Energy.getSitePowerAlarms(data)
            .then((response) => {
                store.dispatch("siteAlarms",{"alarmName":"power","alarmData":response.data.alarms});
            })
            .catch((error) => {
                // console.log(error)
            })
            .finally(() => {
                store.dispatch("displaySpinnerPage", true);
            });
    },
    getSiteHighTempAlarms(siteCode) {
        let data = {
            site_code: siteCode,
        };

        store.dispatch("displaySpinnerPage", false);
        Energy.getSiteHighTempAlarms(data)
            .then((response) => {
                store.dispatch("siteAlarms", {"alarmName":"highTemp","alarmData":response.data.alarms});
            })
            .catch((error) => {
                // console.log(error)
            })
            .finally(() => {
                store.dispatch("displaySpinnerPage", true);
            });
    },
    getSiteGenAlarms(siteCode) {
        let data = {
            site_code: siteCode,
        };

        store.dispatch("displaySpinnerPage", false);
        Energy.getSiteGenAlarms(data)
            .then((response) => {
                store.dispatch("siteAlarms", {"alarmName":"gen","alarmData":response.data.alarms});
            })
            .catch((error) => {
                // console.log(error)
            })
            .finally(() => {
                store.dispatch("displaySpinnerPage", true);
            });
    },
};
