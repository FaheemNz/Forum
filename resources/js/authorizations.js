import { getLoggedInUser } from "./utils/getLoggedInUser.js";

let user = getLoggedInUser();

let authorizations = {
    can(model) {
        return model.user_id === user.id;
    }
};

export default authorizations;
