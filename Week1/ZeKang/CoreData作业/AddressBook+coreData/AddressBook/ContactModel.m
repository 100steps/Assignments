

#import "ContactModel.h"

@implementation ContactModel
//- (void)encodeWithCoder:(NSCoder *)encoder{
//    [encoder encodeObject:self.name forKey:@"name"];
//    [encoder encodeObject:self.phone forKey:@"phone"];
//    [encoder encodeObject:self.qq forKey:@"qq"];
//}
///*
// 将某个  对象  写入文件时候会调用这个方法，
// 而在这个方法中需要说明哪些  属性  需要存储。*/
////用对象归档的方法存储 name，phone，qq。
//- (id)initWithCoder:(NSCoder *)decoder{
//    if (self = [super init]) {
//        self.name = [decoder decodeObjectForKey:@"name"];
//        self.phone = [decoder decodeObjectForKey:@"phone"];
//        self.qq = [decoder decodeObjectForKey:@"qq"];
//    }
//    return self;
//}
///*解析  对象  时会调用这个方法，
// 而在这个方法中需要说明哪些  属性  需要解析*/
@end
//综上，一个编码一个解码。
