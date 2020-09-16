import { getLoggedInUser } from "./utils/getLoggedInUser.js";

let user = getLoggedInUser();

let authorizations = {
    updateReply(reply) {
        return reply.user_id === user.id;
    }
};

export default authorizations;
