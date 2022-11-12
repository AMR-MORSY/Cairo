export default {
    period(period) {
        if (period == "week") {
            var weeks = [];
            for (var i = 1; i <= 48; i++) {
                weeks.push(i);
            }
            let  data = {
                periods: "week",
                figures: weeks,
            };
            return data;
        } else  {
            var months = [
                { num: 1, char: "January" },
                { num: 2, char: "February" },
                { num: 3, char: "March" },
                { num: 4, char: "April" },
                { num: 5, char: "May" },
                { num: 6, char: "Jun" },
                { num: 7, char: "July" },
                { num: 8, char: "August" },
                { num: 9, char: "September" },
                { num: 10, char: "October" },
                { num: 11, char: "November" },
                { num: 12, char: "December" },
            ];
            let data = {
                periods: "month",
                figures: months,
            };
            return data;
        }
    },
};
