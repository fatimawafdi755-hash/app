import os
import time
from datetime import datetime
import ctypes
import ctypes.wintypes

# 🔹 ضع هنا التاريخ الجديد
NEW_DATE = "2026-01-15 18:00:00"


def change_creation_date(path, timestamp):
    FILE_WRITE_ATTRIBUTES = 0x100

    handle = ctypes.windll.kernel32.CreateFileW(
        path,
        FILE_WRITE_ATTRIBUTES,
        0,
        None,
        3,
        0x02000000,  # FILE_FLAG_BACKUP_SEMANTICS (مهم للمجلدات)
        None
    )

    if handle == -1:
        return

    # تحويل التوقيت إلى صيغة ويندوز
    wintime = int((timestamp + 11644473600) * 10000000)
    low = wintime & 0xFFFFFFFF
    high = wintime >> 32

    filetime = ctypes.wintypes.FILETIME(low, high)

    ctypes.windll.kernel32.SetFileTime(
        handle,
        ctypes.byref(filetime),
        ctypes.byref(filetime),
        ctypes.byref(filetime),
    )

    ctypes.windll.kernel32.CloseHandle(handle)


def change_dates_in_folder(folder_path):
    dt = datetime.strptime(NEW_DATE, "%Y-%m-%d %H:%M:%S")
    timestamp = time.mktime(dt.timetuple())

    for item in os.listdir(folder_path):
        full_path = os.path.join(folder_path, item)

        # تغيير تاريخ التعديل
        os.utime(full_path, (timestamp, timestamp))

        # تغيير تاريخ الإنشاء
        change_creation_date(full_path, timestamp)

        print(f"تم تعديل: {item}")

    print("\n✅ انتهى التعديل")


if __name__ == "__main__":
    current_folder = os.path.dirname(os.path.abspath(__file__))
    change_dates_in_folder(current_folder)