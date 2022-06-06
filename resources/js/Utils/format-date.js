export const formatDate = (dateOriginal) => {
    return `${dateOriginal.getFullYear()}-${
        dateOriginal.getMonth() + 1
      }-${dateOriginal.getDate()}`;
}


export const transforDate = (date) => {
    const dateArr = date.split("/");
    return new Date(dateArr[2], dateArr[1] - 1, dateArr[0])
}
