using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class UserRole
    {
        public UserRole()
        {
            User = new HashSet<User>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<User> User { get; set; }
    }
}
